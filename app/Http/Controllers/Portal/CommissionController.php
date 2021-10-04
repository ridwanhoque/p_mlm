<?php

namespace App\Http\Controllers\Portal;

use App\Models\BonusCommission;
use App\Models\CommissionHand;
use App\Models\Option;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommissionController extends Controller
{
    public function index($type)
    {
        $types = [
            'general' => CommissionHand::class,
            'bonus' => BonusCommission::class
        ];

        $model = $types[$type]::query();

        if($type == 'bonus'){
            $model->where('is_active', 1);
        }

        return view('portal.commission.' . $type, [
            'commissions' => $model->get(),
            'option' => Option::commission()->get()->makeOption()
        ]);
    }
}
