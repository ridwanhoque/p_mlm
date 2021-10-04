<?php
namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryRepository
{
    public function featured()
    {
        return Cache::remember('featured-category', now()->addDay(), function (){
            return Category::featured()->get();
        });
    }

    public function forgetAll()
    {
        Cache::forget('featured-category');
        Cache::forget('category-menu');
        Cache::forget('featured-category-menu');
    }

    public function forgetFeatured()
    {
        Cache::forget('featured-category');
    }

    public function categoryMenu()
    {
        return Cache::remember('category-menu', now()->addDay(), function (){
            return Category::query()->select('id', 'name', 'parent_id', 'slug')
                ->root()->with('immediateChildren')->get();
        });
    }

    public function featuredCategoryMenu()
    {
        return Cache::remember('featured-category-menu', now()->addDay(), function (){
            return Category::with('menuChildrens.immediateChildren')->root()->featured()->get();
        });
    }
}