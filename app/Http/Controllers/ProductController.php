<?php

namespace App\Http\Controllers;

use App\Language;
use App\Product;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Zugy\Repos\Product\ProductRepository;

class ProductController extends Controller
{
    /**
     * @var ProductRepository
     */
    private $productRepo;

    /**
     * ProductController constructor.
     * @param ProductRepository $productRepo
     */
    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepo = $productRepo;
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($slug)
    {
        $product = $this->productRepo->getBySlug($slug);

        if($product === null) abort(404, 'That product does not exist');

        $thumbnail = $product->images()->where('id', $product->thumbnail_id)->first();

        return view('pages.product.product-show')->with(['product' => $product, 'thumbnail' => $thumbnail]);
    }

    public function search($query)
    {
        $products = $this->productRepo->search($query);

        return view('pages.product.product-list')->with(['products' => $products, 'query' => $query]);
    }
}
