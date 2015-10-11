<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Nicolaslopezj\Searchable\SearchableTrait;

class Product extends Model
{
    use Translatable;
    use SearchableTrait;

    protected $table = 'products';

    public $translatedAttributes = ['slug', 'title', 'description', 'meta_description'];

    /**
     * Searchable rules
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'product_translations.title' => 10,
            'product_translations.description' => 2,
        ],
        'joins' => [
            'product_translations' => ['products.id', 'product_translations.product_id']
        ]
    ];

    protected $with = ['tax_class'];

    public function images()
    {
        return $this->hasMany('App\ProductImage');
    }

    public function cover()
    {
        $images = $this->images()->get();

        if($images->count() === 0) {
            return asset('/img/zugy-placeholder-image.png');
        } else {
            return $images->first()->url;
        }
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
        if($language_code === null) $language_code = LaravelLocalization::getCurrentLocale();

        return LaravelLocalization::getURLFromRouteNameTranslated($language_code, 'routes.product', ['slug' => $this->slug]);
    }

    /*
     * Accessors
     */

    /**
     * Generate array to form breadcrumbs
     * @return array
     */
    public function getBreadcrumbsAttribute()
    {
        $category_id = $this->categories()->first()->id;

        $tree = Category::with('translations')->get();

        $node = $tree->where('id', $category_id)->first();

        $parent_id = $node->parent_id;

        $breadcrumbs = [];
        while($parent_id !== null) {
            array_unshift($breadcrumbs, ['name' => $node->name, 'slug' => $node->slug]);
            $node = $tree->where('id', $parent_id)->first();
            $parent_id = $node->parent_id;
        }

        array_unshift($breadcrumbs, ['name' => $node->name, 'slug' => $node->slug]);

        return $breadcrumbs;
    }
}
