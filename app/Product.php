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
}
