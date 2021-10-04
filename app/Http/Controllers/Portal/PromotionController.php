<?php

namespace App\Http\Controllers\Portal;

use App\Models\PromotionalDesignation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PromotionController extends Controller
{
    public function index()
    {
        return view('portal.promotion.index', [
            'designations' => PromotionalDesignation::with('requiredDesignation')->get()
        ]);
    }
}
