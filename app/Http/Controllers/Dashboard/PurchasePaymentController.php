<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Resources\PurchaseListResource;
use App\Http\Resources\PurchasePaymentResource;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PurchasePaymentController extends Controller
{
    public function index(Purchase $purchase)
    {
        return PurchasePaymentResource::collection(
            $purchase->payments()->with('user')->latest()->get()
        )->additional([
            'purchase' => new PurchaseListResource($purchase)
        ]);
    }

    public function store(Purchase $purchase, Request $request)
    {
        $attributes = $request->validate([
            'amount' => 'required|numeric|min:1'
        ]);

        $purchase->payments()->create($attributes);

        return create_response();
    }
}
