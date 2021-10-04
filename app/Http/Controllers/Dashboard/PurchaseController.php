<?php

namespace App\Http\Controllers\Dashboard;

use Exception;
use App\Models\Purchase;
use App\Http\Controllers\Controller;
use App\Http\Resources\PurchaseListResource;
use Illuminate\Http\{Request, Resources\Json\AnonymousResourceCollection, Response};

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $purchase = Purchase::query();


        $purchase->with('supplier');

        return PurchaseListResource::collection(
            $purchase->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'products' => 'required',
            'paid' => 'numeric',
            'products.*.product_id' => 'required',
            'products.*.quantity' => 'required|numeric|min:1',
            'products.*.price' => 'required|numeric|min:1',
        ]);

        $attributes['total'] = array_reduce($attributes['products'], function ($carry, $product){
            return ($carry + ($product['quantity'] * $product['price']));
        }, 0);

        /** @var Purchase $purchase */
        $purchase = Purchase::create($attributes);

        $purchase->products()->createMany($attributes['products']);

        $purchase->makePayment($request->paid);

        return create_response();
    }

    /**
     * Display the specified resource.
     *
     * @param Purchase $purchase
     * @return Response
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Purchase $purchase
     * @return Response
     * @throws Exception
     */
    public function destroy(Purchase $purchase)
    {
        $purchase->delete();

        return delete_response();
    }
}
