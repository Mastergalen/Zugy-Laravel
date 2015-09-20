<?php
/**
 * User: Galen Han
 * Date: 18.09.2015
 * Time: 02:21
 */

namespace Zugy\Repos\Product;


interface ProductRepository
{
    public function category($category_slug);
    public function getBySlug($slug);
}