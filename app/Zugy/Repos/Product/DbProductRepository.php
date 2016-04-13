<?php

namespace Zugy\Repos\Product;

use App\Category;
use App\Language;
use App\Product;
use App\ProductDescription;
use App\ProductTranslation;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Zugy\Repos\Category\CategoryRepository;
use Zugy\Repos\DbRepository;

class DbProductRepository extends DbRepository implements ProductRepository
{
    /**
     * @var CategoryRepository
     */
    protected $categoryRepo;
    /**
     * @var Product
     */
    protected $model;

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
     * @param string $sort
     * @param string $direction
     * @return
     */
    public function all($sort = 'sales', $direction = 'desc')
    {
        $query = $this->productQueryBuilder()->orderBy($sort, $direction);

        $orderedProductIds = collect($query->get())->pluck('id');

        $orderedProductIdsStr = $orderedProductIds->implode(',');
        $products = $this->model->with('translations')
            ->whereIn('id', $orderedProductIds)
            ->orderByRaw("FIELD(id, $orderedProductIdsStr)")
            ->paginate(15);

        return $products;
    }

    /**
     * Fetch all products for a category slug
     * @param $category_slug
     * @param string $sort
     * @param string $direction
     * @return
     */
    public function category($category_slug, $sort = 'sales', $direction = 'desc')
    {
        $category = $this->categoryRepo->getBySlug($category_slug);

        $categoryIds = $this->categoryRepo->children($category->id);

        $productIds = collect(
            DB::table('products_to_categories')
                ->whereIn('category_id', $categoryIds)
                ->get()
            )->unique('product_id')->pluck('product_id');

        $query = $this->productQueryBuilder()
                    ->orderBy($sort, $direction)
                    ->whereIn('products.id', $productIds); // Category filter;

        $orderedProductIds = collect($query->get())->pluck('id');

        if($orderedProductIds->isEmpty()) {
            return new Paginator([], 15);
        }

        $orderedProductIdsStr = $orderedProductIds->implode(',');
        $products = $this->model->with('translations')
                                ->whereIn('id', $orderedProductIds)
                                ->orderByRaw("FIELD(id, $orderedProductIdsStr)")
                                ->paginate(15);

        return $products;
    }

    /**
     * Fetch a product by its slug
     * @param $slug
     * @return mixed
     */
    public function getBySlug($slug)
    {
        $product = $this->model->with(['images', 'attributes', 'translations'])->whereHas('translations', function($query) use ($slug) {
           $query->where('locale', '=', LaravelLocalization::getCurrentLocale())
                 ->where('slug', '=', $slug);
        })->first();

        return $product;
    }

    public function search($query)
    {
        $algoliaResults = \App\Product::search($query, [
            'restrictSearchableAttributes' => ['translation_' . \Localization::getCurrentLocale()],
        ]);

        $productIds = [];
        foreach($algoliaResults['hits'] as $hit) {
            $productIds[] = $hit['objectID'];
        }

        return $this->model->whereIn('id', $productIds)->paginate(15);
    }

    /**
     * Build joined table so that sales for product can be calculated
     * @return mixed
     */
    private function productQueryBuilder() {
         return DB::table('products')
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->leftJoin('orders', 'orders.id', '=', 'order_items.order_id')
            ->selectRaw('products.*, SUM(
                CASE WHEN orders.order_status = 4 THEN 
                    0 
                ELSE 
                    order_items.quantity 
                END) as sales') //Ignore cancelled orders
            ->groupBy('products.id')
            ->where('products.stock_quantity', '>', 0); //Hide items that are out of stock
    }
}