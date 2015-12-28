<?php

namespace App\Services;

use App\Product;
use App\ProductImage;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\LaravelLocalization;
use Illuminate\Support\Facades\Validator;

class CreateOrUpdateProduct
{
    public function handler(Request $request, $productId = null)
    {
        $languages = \Localization::getSupportedLanguagesKeys();

        $rules = [
            'price' => 'required|numeric|min:0',
            'compare_price' => 'numeric|min:0',
            'tax_class_id' => 'required|exists:tax_classes,id',
            'stock' => 'required|integer|min:0',
            'images' => 'required|integerArray',
            'category_id' => 'required|exists:categories,id',
            'thumbnail_id' => 'required|exists:product_images,id',
            'attributes.*' => 'max:255',
        ];

        foreach ($languages as $l) {
            $rules["meta.{$l}.title"] = "required|max:255";
            $rules["meta.{$l}.slug"] = "required|max:255|alpha_dash|unique:product_translations,slug,NULL,id,locale,$l"; //TODO Validate slug
            $rules["meta.{$l}.description"] = "required|max:65535";
            $rules["meta.{$l}.meta_description"] = "required|max:255";
        }

        Validator::extend('integerArray', function($attribute, $value, $parameters)
        {
            foreach($value as $v) {
                if(!is_numeric($v) && !is_int((int)$v)) return false;
            }
            return true;
        });

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            if ($productId === null) { //Create new product
                $product = new Product();
            } else {
                $product = Product::find($productId);
            }

            $product->stock_quantity = $request->input('stock');
            $product->price = $request->input('price');
            $product->compare_price = $request->input('compare_price');
            $product->tax_class_id = $request->input('tax_class_id');
            $product->thumbnail_id = $request->input('thumbnail_id');

            foreach ($languages as $l) {
                $product->translateOrNew($l)->title = $request->input("meta.{$l}.title");
                $product->translateOrNew($l)->slug = $request->input("meta.{$l}.slug");
                $product->translateOrNew($l)->description = $request->input("meta.{$l}.description");
                $product->translateOrNew($l)->meta_description = $request->input("meta.{$l}.meta_description");
            }

            $product->save();

            $product->categories()->attach($request->input('category_id'));

            //TODO Validate if attribute IDs exist
            foreach($request->input('attributes') as $key => $value) {
                if(trim($value) == "") continue;

                $product->attributes()->attach($key, ['value' => $value]);
            }

            $product->save();

            ProductImage::whereIn('id', $request->input('images'))->update(['product_id' => $product->id]);
        }

        return redirect()->action('Admin\CatalogueController@index')->with('success', 'Product added successfully');
    }
}