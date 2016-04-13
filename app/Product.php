<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Product extends Model
{
    use SoftDeletes;
    use Translatable;
    use \AlgoliaSearch\Laravel\AlgoliaEloquentTrait;

    protected $table = 'products';

    protected $appends = ['thumbnail_url'];

    public static $perEnvironment = true; // Index name will be 'products_{\App::environment()}';

    public $algoliaSettings = [
        'attributesToIndex' => [
            'translation_en',
            'translation_it',
            'categories',
            'stock_quantity',
            'price',
            'weight',
        ],
        'customRanking' => [

        ],
    ];

    public function getAlgoliaRecord()
    {
        /**
         * Load the categories relation so that it's available
         *  in the laravel toArray method
         */
        $fields = [
            'stock_quantity' => $this->stock_quantity,
            'price' => (float) $this->price,
            'weight' => (float) $this->weight,
            'categories' => $this->categories,
        ];

        $fields['categories'] = [];
        foreach($this->categories as $c) {
            $fields['categories'][] = $c->id;
        }

        foreach($this->translations as $translation) {
            $fields['translation_' . $translation->locale] = [
                'title' => $translation->title,
                'slug' => $translation->slug,
                'description' => $translation->meta_description,
                'meta_description' => $translation->meta_description
            ];
        }

        return $fields;
    }

    public function getFinalIndexName(Model $model, $indexName)
    {
        $environment = \App::environment();
        if($environment == "testing") $environment = 'local';

        $env_suffix = property_exists($model, 'perEnvironment') && $model::$perEnvironment === true ? '_'. $environment() : '';

        return $indexName.$env_suffix;
    }

    public $translatedAttributes = ['slug', 'title', 'description', 'meta_description'];

    protected $fillable = ['slug', 'title', 'description', 'meta_description'];

    protected $with = ['tax_class'];

    /*
     * Relations
     */

    public function images()
    {
        return $this->hasMany('App\ProductImage');
    }

    public function tax_class() {
        return $this->belongsTo('App\TaxClass');
    }

    public function attributes()
    {
        return $this->belongsToMany('App\Attribute', 'products_to_attributes')->withPivot('value');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category', 'products_to_categories');
    }

    public function getUrl($language_code = null)
    {
        if(isset($this->attributes['url'])) {
            return $this->attributes['url'];
        }

        if($language_code === null) $language_code = LaravelLocalization::getCurrentLocale();

        $url = LaravelLocalization::getURLFromRouteNameTranslated($language_code, 'routes.product', ['slug' => $this->slug]);

        $this->attributes['url'] = $url;

        return $url;
    }

    /*
     * Actions
     */

    /**
     * Also delete all basket items containing this product
     * @throws \Exception
     */
    public function delete()
    {
        Basket::where('product_id', '=', $this->attributes['id'])->delete();

        parent::delete(); //Soft delete
    }

    /*
     * Accessors
     */

    /**
     * Fetch URL thumbnail for product
     * @return string
     */
    public function getThumbnailUrlAttribute() {
        if(isset($this->attributes['thumbnail_url'])) {
            return $this->attributes['thumbnail_url'];
        }

        $thumbnailId = $this->attributes['thumbnail_id'];

        if($thumbnailId !== null) {
            $url = $this->images->find($thumbnailId)->url;
        } else {
            $images = $this->images;

            if($images->count() === 0) {
                $url =  asset('/img/zugy-placeholder-image.png');
            } else {
                $url = $images->first()->url;
            }
        }

        $this->attributes['thumbnail_url'] = $url;

        return $url;
    }

    /**
     * Generate array to form breadcrumbs
     * @return array
     */
    public function getBreadcrumbsAttribute()
    {
        $category_id = $this->categories()->first()->id;

        $categories = Category::with('translations')->get()->keyBy('id');

        $node = $categories[$category_id];

        $parent_id = $node->parent_id;

        $breadcrumbs = [];

        while($parent_id !== null) {
            array_unshift($breadcrumbs, ['name' => $node->name, 'slug' => $node->slug]);
            $node = $categories[$parent_id];
            $parent_id = $node->parent_id;
        }

        array_unshift($breadcrumbs, ['name' => $node->name, 'slug' => $node->slug]);

        return $breadcrumbs;
    }

    /**
     * Calculate how many times product has been sold
     * @return mixed
     */
    public function getSalesAttribute()
    {
        return DB::table('order_items')
                   ->join('orders', 'order_items.order_id', '=', 'orders.id')
                   ->select('order_items.*', 'orders.order_status')
                   ->where('product_id', '=', $this->attributes['id'])
                   ->where('orders.order_status', '!=', 4) //Ignore cancelled orders
                   ->sum('order_items.quantity');
    }

    /**
     * Only include products that are in stock
     * @param $query
     */
    public function scopeInStock($query) {
        return $query->where('stock_quantity', '>', 0);
    }
}
