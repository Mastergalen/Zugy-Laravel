<?php

namespace Zugy\Repos\Category;


interface CategoryRepository
{
    /**
     * Return all child category IDs and itself
     * @param $categoryId
     * @return mixed
     */
    public function children($categoryId);

    /**
     * Return the category matching the slug
     * @param $slug
     * @return mixed
     */
    public function getBySlug($slug);
}