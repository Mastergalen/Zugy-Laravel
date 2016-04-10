<?php

namespace App\Http\Controllers;

use App\Http\Requests;
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
     * @param  String  $slug
     * @return Response
     */
    public function show($slug)
    {
        $product = $this->productRepo->getBySlug($slug);

        if($product === null) abort(404, trans('product.404'));

        $thumbnail = $product->images()->where('id', $product->thumbnail_id)->first();

        $translations = $product->translations()->pluck('slug', 'locale');

        foreach($translations as $locale => $slug) {
            $translations[$locale] = \Localization::getURLFromRouteNameTranslated($locale, 'routes.product', ['slug' => $slug]);
        }

        return view('pages.product.product-show')->with(['product' => $product, 'thumbnail' => $thumbnail, 'translations' => $translations]);
    }

    public function search($query)
    {
        $products = $this->productRepo->search($query);

        return view('pages.product.product-list')->with(['products' => $products, 'query' => $query]);
    }
}
