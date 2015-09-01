<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

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
