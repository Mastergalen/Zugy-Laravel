<?php

namespace App\Http\Controllers;

use App\Language;
use App\Product;
use Illuminate\Http\Request;

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
    public function show($language_code, $slug)
    {
        $language_id = Language::where('code', '=', strtoupper($language_code))->first()->id;

        $product = Product::with(['description' => function($query) use ($language_id, $slug) {
            $query->where('slug', '=', $slug)
                  ->where('language_id', '=', $language_id);
            }])
            ->with('images')
            ->with(['attributes.description' => function($query) use($language_id) {
                $query->where('language_id', '=', $language_id);
            }])->first();

        if($product === null) abort(404);

        return view('pages.product')->with(['product' => $product, 'language_id' => $language_id]);
    }
}
