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
        return $this->belongsToMany('App\Attributes', 'products_to_attributes');
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
}
