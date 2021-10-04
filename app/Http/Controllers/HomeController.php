<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Package;
use App\Repositories\CategoryRepository;
use App\Repositories\SlideRepository;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @param CategoryRepository $categoryRepository
     * @param SlideRepository $slideRepository
     * @return Renderable
     */
    public function index(CategoryRepository $categoryRepository, SlideRepository $slideRepository)
    {
        return view('pages.home', [
            'featured_categories' => $categoryRepository->featured(),
            'slides' => $slideRepository->getSlides(),
            'home_categories' => Category::with(['products' => function(BelongsToMany $query){
                $query->with('firstImage')->latest('products.created_at')->take(15);
            }])->has('products')->showOnHome()->get(),
            'packages' => Package::with('firstImage')->forHomepage()->get()
        ]);
    }
}
