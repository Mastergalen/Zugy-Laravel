<?php

namespace App\Http\Controllers;

use App\Language;
use App\Product;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($slug)
    {
        $language_id = Language::where('code', '=', strtoupper(LaravelLocalization::getCurrentLocale()))->first()->id;

        $product = Product::with(['description' => function($query) use ($language_id, $slug) {
            $query->where('slug', '=', $slug)
                  ->where('language_id', '=', $language_id);
            }])
            ->with('images')
            ->with(['attributes.description' => function($query) use($language_id) {
                $query->where('language_id', '=', $language_id);
            }])->get()->where('description.0.slug', $slug)->first();

        if($product === null) abort(404, 'That product does not exist');

        return view('pages.product')->with(['product' => $product, 'language_id' => $language_id]);
    }
}
