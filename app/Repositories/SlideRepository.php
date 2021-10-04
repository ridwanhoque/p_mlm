<?php
namespace App\Repositories;

use App\Models\Slide;
use Illuminate\Support\Facades\Cache;

class SlideRepository
{
    public function getSlides()
    {
        return Cache::remember('slides', now()->addDay(), function (){
            return Slide::all();
        });
    }

    public function forgetSlides()
    {
        Cache::forget('slides');
    }
}