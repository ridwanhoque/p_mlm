<?php

namespace App\Http\Controllers\Portal;

use App\Http\Resources\Portal\JoiningProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $product = Product::with('immediateCategory.parents');

        if($request->has('joining')){
            $product->whereIn('position', [2, 3]);
        }else{
            $product->whereIn('position', [1, 3]);
        }

        if($request->filled('code')){
            $product->whereId($request->get('code'));
        }

        if($request->filled('name')){
            $product->where('name', 'like', "%{$request->get('name')}%");
        }

        if($request->filled('category')){
            $product->whereHas('categories', function ($query) use($request){
                $query->where('categories.id', $request->category);
            });
        }

        if($request->filled('sort_by')){
            $product->orderBy('sale_price', $request->sort_by);
        }

        if($request->has('all')){
            return JoiningProductResource::collection($product->get());
        }

        return view('portal.product.index', [
            'products' => $product->paginate()->appends($request->query()),
            'categories' => Category::root()->get()
        ]);
    }
}
