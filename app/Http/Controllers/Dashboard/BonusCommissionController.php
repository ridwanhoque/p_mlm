<?php

namespace App\Http\Controllers\Dashboard;

use Exception;
use App\Models\BonusCommission;
use App\Http\Controllers\Controller;
use App\Http\Resources\BonusCommissionResource;
use Illuminate\Http\{Request, Response, Resources\Json\AnonymousResourceCollection};

class BonusCommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection|Response
     */
    public function index()
    {
        return BonusCommissionResource::collection(
            BonusCommission::all()
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
            'name' => 'required|unique:bonus_commissions',
            'percentage' => 'required|numeric|between:0,100',
            'payable' => 'required|string',
            'is_active' => 'required|in:0,1'
        ]);

        BonusCommission::create($attributes);

        return create_response();
    }

    /**
     * Display the specified resource.
     *
     * @param BonusCommission $bonusCommission
     * @return BonusCommissionResource|Response
     */
    public function show(BonusCommission $bonusCommission)
    {
        return new BonusCommissionResource($bonusCommission);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param BonusCommission $bonusCommission
     * @return Response
     */
    public function update(Request $request, BonusCommission $bonusCommission)
    {
        $attributes = $request->validate([
            'name' => 'required|unique:bonus_commissions,name,' . $bonusCommission->id,
            'percentage' => 'required|numeric|between:0,100',
            'payable' => 'required|string',
            'is_active' => 'required|in:0,1'
        ]);

        $bonusCommission->update($attributes);

        return update_response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BonusCommission $bonusCommission
     * @return Response
     * @throws Exception
     */
    public function destroy(BonusCommission $bonusCommission)
    {
        $bonusCommission->delete();

        return delete_response();
    }
}
