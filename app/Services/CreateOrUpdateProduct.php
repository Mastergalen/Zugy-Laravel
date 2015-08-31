<?php
/**
 * User: Galen Han
 * Date: 26.07.2015
 * Time: 14:52
 */

namespace App\Services;

use App\Product;
use App\ProductImage;
use Illuminate\Http\Request;
use App\Language;
use Illuminate\Support\Facades\Validator;

class CreateOrUpdateProduct
{
    public function handler(Request $request, $productId = null)
    {
        $languages = Language::all();

        $rules = [
            'price' => 'required|numeric|min:0',
            'compare_price' => 'numeric|min:0',
            'tax_class_id' => 'required|exists:tax_classes,id',
            'stock' => 'required|integer|min:0',
            'images' => 'required|integerArray',
            'category_id' => 'required|exists:categories,id'
        ];

        foreach ($languages as $l) {
            $rules["meta.{$l['code']}.title"] = "required|max:255";
            $rules["meta.{$l['code']}.slug"] = "required|max:255|alpha_dash|unique:products_description,slug,NULL,id,language_id,{$l['id']}"; //TODO Validate slug
            $rules["meta.{$l['code']}.description"] = "required|max:65535";
            $rules["meta.{$l['code']}.meta_description"] = "required|max:255";
        }

        if ($productId !== null) {
            //Update existing product

            //TODO Check if product ID exists
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
            $product->save();
            $product->categories()->attach($request->input('category_id'));

            //TODO Validate if attribute IDs exist
            foreach($request->input('attributes') as $a) {
                $product->attributes()->attach($a['id'], ['value' => $a['value']]);
            }

            foreach ($languages as $l) {
                $product->description()->create([
                    "language_id" => $l['id'],
                    "title" => $request->input("meta.{$l['code']}.title"),
                    "slug" => $request->input("meta.{$l['code']}.slug"),
                    "description" => $request->input("meta.{$l['code']}.description"),
                    "meta_description" => $request->input("meta.{$l['code']}.meta_description"),
                ]);
            }

            $product->save();

            ProductImage::whereIn('id', $request->input('images'))->update(['product_id' => $product->id]);
        }

        return redirect()->action('Admin\CatalogueController@index')->with('success', 'Product added successfully');
    }
}