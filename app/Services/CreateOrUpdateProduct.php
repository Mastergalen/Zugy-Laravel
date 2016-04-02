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

        if ($productId === null) { //Create new product
            $product = new Product();
        } else {
            $product = Product::find($productId);

            $productTranslations = $product->translations()->get()->keyBy('locale');
        }

        $rules = [
            'price' => 'required|numeric|min:0',
            'compare_price' => 'numeric|min:0',
            'tax_class_id' => 'required|exists:tax_classes,id',
            'stock_quantity' => 'required|integer|min:0',
            'images' => 'required|integerArray',
            'category_id' => 'required|exists:categories,id',
            'thumbnail_id' => 'exists:product_images,id',
            'attributes.*' => 'max:255',
        ];

        foreach ($languages as $l) {
            $rules["meta.{$l}.title"] = "required|max:255";
            $rules["meta.{$l}.slug"] = "required|max:255|alpha_dash|unique:product_translations,slug,{$product->translateOrNew($l)['slug']},slug,locale,$l";
            $rules["meta.{$l}.description"] = "required|max:65535";
            $rules["meta.{$l}.meta_description"] = "required|max:255";
        }

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $product->stock_quantity = $request->input('stock_quantity');
            $product->price = $request->input('price');
            $product->compare_price = $request->input('compare_price');
            $product->tax_class_id = $request->input('tax_class_id');

            if($request->input('thumbnail_id') != "") {
                $product->thumbnail_id = $request->input('thumbnail_id');
            }

            foreach ($languages as $l) {
                $product->translateOrNew($l)->title = $request->input("meta.{$l}.title");
                $product->translateOrNew($l)->slug = $request->input("meta.{$l}.slug");
                $product->translateOrNew($l)->description = $request->input("meta.{$l}.description");
                $product->translateOrNew($l)->meta_description = $request->input("meta.{$l}.meta_description");
            }

            $product->save();

            $product->categories()->sync([$request->input('category_id')]);

            //TODO Validate if attribute IDs exist
            $sync = [];
            foreach($request->input('attributes') as $key => $value) {
                if(trim($value) == "") continue;
                $sync[$key] = ['value' => $value];
            }

            $product->attributes()->sync($sync);

            $product->save();

            //Ensure that thumbnail ID gets updated with product ID
            $productImages = $request->input('images');
            if(!in_array((int) $request->input('thumbnail_id'), $productImages)) {
                $productImages[] = (int) $request->input('thumbnail_id');
            }
            ProductImage::whereIn('id', $productImages)->update(['product_id' => $product->id]);
        }

        return redirect()->action('Admin\CatalogueController@index')->with('success', 'Product added successfully');
    }
}
