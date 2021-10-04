<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\DistrictRepository;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function index(Request $request, DistrictRepository $districtRepository)
    {
        /** @var User $user */
        $user = $request->user();

        return [
            'districts' => $districtRepository->getAll(),
            'shipping_address' => $user->meta->get('present_address')
        ];
    }
}
