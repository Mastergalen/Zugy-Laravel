<?php

namespace App;

class ProductTranslation extends \Eloquent
{
    public $timestamps = false;
    protected $fillable = ['slug', 'title', 'description', 'meta_description'];
}