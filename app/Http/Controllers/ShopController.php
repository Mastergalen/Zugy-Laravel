<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Zugy\Repos\Category\CategoryRepository;
use Zugy\Repos\Product\ProductRepository;

class ShopController extends Controller
{
    /**
     * @var ProductRepository
     */
    private $productRepo;
    /**
     * @var CategoryRepository
     */
    private $categoryRepo;

    /**
     * ShopController constructor.
     * @param $productRepo ProductRepository
     */
    public function __construct(ProductRepository $productRepo, CategoryRepository $categoryRepo)
    {
        $this->productRepo = $productRepo;
        $this->categoryRepo = $categoryRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return "nothing yet";
    }

    public function category($category_slug) {
        $category = $this->categoryRepo->getBySlug($category_slug);

        $products = $this->productRepo->category($category_slug);

        return view('pages.shop.category')->with(compact('products', 'category'));
    }
}
