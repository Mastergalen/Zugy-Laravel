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

        return view('pages.product')->with(['product' => $product]);
    }
}
