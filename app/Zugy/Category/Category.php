<?php

namespace Zugy\Category;

class Category
{
    public function getDirectSubCategories(\App\Category $category) {
        return \App\Category::where('parent_id', '=', $category->id)->get();
    }
}