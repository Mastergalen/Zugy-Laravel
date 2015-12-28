<?php

namespace Zugy\Repos\Product;

use App\Category;
use App\Language;
use App\Product;
use App\ProductDescription;
use App\ProductTranslation;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Zugy\Repos\Category\CategoryRepository;
use Zugy\Repos\DbRepository;

class DbProductRepository extends DbRepository implements ProductRepository
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepo;
    /**
     * @var Product
     */
    private $model;

    /**
     * DbProductRepository constructor.
     * @param $categoryRepo CategoryRepository
     */
    public function __construct(Product $model, CategoryRepository $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
        $this->model = $model;
    }

    /**
     * Fetch all products
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Fetch all products for a category slug
     */
    public function category($category_slug)
    {
        $category = $this->categoryRepo->getBySlug($category_slug);

        $categoryIds = $this->categoryRepo->children($category->id);

        $productIds = collect(
            \DB::table('products_to_categories')
                ->whereIn('category_id', $categoryIds)
                ->get()
            )->unique('product_id')->pluck('product_id');

        $products = $this->model->findMany($productIds);

        $products->load('translations');

        return $products;
    }

    /**
     * Fetch a product by its slug
     * @param $slug
     * @return mixed
     */
    public function getBySlug($slug)
    {
        $product = $this->model->with(['images', 'attributes'])->whereHas('translations', function($query) use ($slug) {
           $query->where('locale', '=', LaravelLocalization::getCurrentLocale())
                 ->where('slug', '=', $slug);
        })->first();

        return $product;
    }

    public function search($query)
    {
        return $this->model->search($query)->get();
    }


}