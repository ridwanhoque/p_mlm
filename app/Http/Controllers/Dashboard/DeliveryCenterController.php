<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Resources\DeliveryCenterResource;
use App\Models\DeliveryCenter;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class DeliveryCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection|Response
     */
    public function index()
    {
        return DeliveryCenterResource::collection(
            DeliveryCenter::all()
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
            'name' => 'required|unique:delivery_centers',
            'address' => 'required'
        ]);

        DeliveryCenter::create($attributes);

        return create_response();
    }

    /**
     * Display the specified resource.
     *
     * @param DeliveryCenter $deliveryCenter
     * @return DeliveryCenter|Response
     */
    public function show(DeliveryCenter $deliveryCenter)
    {
        return new DeliveryCenter($deliveryCenter);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param DeliveryCenter $deliveryCenter
     * @return Response
     */
    public function update(Request $request, DeliveryCenter $deliveryCenter)
    {
        $attributes = $request->validate([
            'name' => 'required|unique:delivery_centers,name,' . $deliveryCenter->id,
            'address' => 'required'
        ]);

        $deliveryCenter->update($attributes);

        return update_response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeliveryCenter $deliveryCenter
     * @return Response
     * @throws Exception
     */
    public function destroy(DeliveryCenter $deliveryCenter)
    {
        $deliveryCenter->delete();

        return delete_response();
    }
}
