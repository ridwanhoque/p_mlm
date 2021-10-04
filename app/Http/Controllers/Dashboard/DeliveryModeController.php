<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Resources\DeliveryModeResource;
use App\Models\DeliveryMode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeliveryModeController extends Controller
{
    public function index()
    {
        return DeliveryModeResource::collection(
            DeliveryMode::all()
        );
    }
}
