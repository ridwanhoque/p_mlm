<?php
namespace App\Repositories;

use App\Models\Option;
use Illuminate\Support\Facades\Cache;

class OptionRepository
{
    public function getOptions()
    {
        return Cache::remember('site_options', now()->addDay(), function (){
            return Option::all()->makeOption();
        });
    }

    public function forgetCache()
    {
        Cache::forget('site_options');
    }
}