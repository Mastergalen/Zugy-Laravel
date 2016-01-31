<?php
/**
 * User: Galen Han
 * Date: 18.09.2015
 * Time: 02:21
 */

namespace Zugy\Repos\Product;


interface ProductRepository
{
    public function all($sort = 'sales', $direction = 'desc');
    public function category($category_slug, $sort = 'sales', $direction = 'desc');
    public function getBySlug($slug);
    public function search($query);
}