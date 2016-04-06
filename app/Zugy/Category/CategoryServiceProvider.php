<?php

namespace Zugy\Category;

use Illuminate\Support\ServiceProvider;

class CategoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('category', function()
        {
            return new Category();
        });
    }
}