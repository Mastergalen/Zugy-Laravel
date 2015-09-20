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

    public function category($category_slug) {
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

    public function getBySlug($slug)
    {
        $language_id = Language::getLanguageId();

        $productId = ProductTranslation::where('slug', '=', $slug)
            ->where('locale', '=', LaravelLocalization::getCurrentLocale())->first()->product_id;

        $product = $this->model->find($productId);

        $product->load(['images' => function(){}, 'attributes.description' => function($query) use($language_id) {
            $query->where('language_id', '=', $language_id);
        }]);

        return $product;
    }


}