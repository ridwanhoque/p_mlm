<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {

    }

    public function show(Category $category, Request $request)
    {
        return view('category.product', compact('category'), [
            'products' => $category->products()
                ->with('firstImage')->paginate(20)->appends($request->query()),
            'packages' => $category->packages->load('firstImage')
        ]);
    }
}
