<?php

namespace App;


class CategoryTranslation extends \Eloquent
{
    public $timestamps = false;
    protected $fillable = ['name', 'slug', 'meta_description'];
}