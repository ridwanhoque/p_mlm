<?php
namespace App\Repositories;

use App\Models\District;
use Illuminate\Support\Facades\Cache;

class DistrictRepository
{
    public function getAll()
    {
        return Cache::rememberForever('districts', function (){
           return District::orderBy('name')->get();
        });
    }
}