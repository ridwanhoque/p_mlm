<?php

namespace App\Http\Controllers;

use App\Http\Resources\Web\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product, Request $request)
    {
        $product->load('images');

        if($request->ajax() && $request->has('ajax')){
            return new ProductResource($product);
        }

        return view('product.show', compact('product'), [
            'related_products' => $product->related()->with('firstImage')->take(20)->get()
        ]);
    }
}
