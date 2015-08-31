<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductDescription extends Model
{
    protected $table = 'products_description';

    public $timestamps = false;

    protected $fillable = [
        'language_id',
        'title',
        'slug',
        'description',
        'meta_description',
    ];
}
