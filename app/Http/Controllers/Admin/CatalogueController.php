<?php

namespace App\Http\Controllers\Admin;

use App\Language;
use App\Product;
use App\Services\CreateOrUpdateProduct;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CatalogueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $products = Product::with('translations')->paginate(30);
        return view('admin.pages.catalogue.index')->with(['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $languages = Language::all();

        return view('admin.pages.catalogue.create')->with(['languages' => $languages]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request, CreateOrUpdateProduct $service)
    {
        return $service->handler($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, CreateOrUpdateProduct $service, $productId)
    {
        $service->handler($request, $productId);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
