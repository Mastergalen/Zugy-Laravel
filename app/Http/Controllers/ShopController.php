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
    public function index(Request $request)
    {
        if($request->has('sort')) {
            $sort = $request->input('sort');
        } else {
            $sort = 'sales';
        }

        if($request->has('direction')) {
            $direction = $request->input('direction');
        } else {
            $direction = 'desc';
        }

        $products = $this->productRepo->all($sort, $direction);

        return view('pages.product.product-list')->with(compact('products', 'category'));
    }

    public function category(Request $request, $category_slug) {
        if($request->has('sort')) {
            $sort = $request->input('sort');
        } else {
            $sort = 'sales';
        }

        if($request->has('direction')) {
            $direction = $request->input('direction');
        } else {
            $direction = 'desc';
        }

        $category = $this->categoryRepo->getBySlug($category_slug);

        $products = $this->productRepo->category($category_slug, $sort, $direction);

        return view('pages.product.product-list')->with(compact('products', 'category'));
    }
}
