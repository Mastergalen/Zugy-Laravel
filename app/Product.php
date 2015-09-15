<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Product extends Model
{
    protected $table = 'products';

    protected $with = ['tax_class'];

    //TODO If no images, display blank image
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

    public function description()
    {
        return $this->hasMany('App\ProductDescription');
    }

    public function getDescription($language_id)
    {
        return $this->description()->where('language_id', '=', $language_id)->first();
    }

    public function getUrl($language_code = null)
    {
        if($language_code === null) $language_code = LaravelLocalization::getCurrentLocale();

        $description = $this->getDescription(Language::getLanguageId($language_code));

        return LaravelLocalization::getURLFromRouteNameTranslated($language_code, 'routes.product', ['slug' => $description->slug]);
    }

    /**
     * Generate array to form breadcrumbs
     * @return array
     */
    public function getBreadcrumbsAttribute()
    {
        $category_id = $this->categories()->get()->pluck('id')->first();

        $tree = Category::with('description')->get();

        $node = $tree->where('id', $category_id)->first();

        $parent_id = $node->parent_id;

        $breadcrumbs = [];
        while($parent_id !== null) {
            array_unshift($breadcrumbs, ['description' => $node->toArray()['description'], 'url' => '']);
            $node = $tree->where('id', $parent_id)->first();
            $parent_id = $node->parent_id;
        }

        array_unshift($breadcrumbs, ['description' => $node->toArray()['description'], 'url' => '']);

        return $breadcrumbs;
    }
}
