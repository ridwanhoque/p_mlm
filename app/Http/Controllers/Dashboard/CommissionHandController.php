<?php

namespace App\Http\Controllers\Dashboard;

use Exception;
use App\Models\CommissionHand;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommissionHandResource;
use Illuminate\Http\{Request, Response, Resources\Json\AnonymousResourceCollection};

class CommissionHandController extends Controller
{
    protected $rules = [
        'label' => 'required|string',
        'hand_level' => 'required|integer',
        'commission' => 'required|numeric|between:0,100'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection|Response
     */
    public function index()
    {
        return CommissionHandResource::collection(
            CommissionHand::all()
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
        $request->validate($this->rules);

        CommissionHand::create($request->all());

        return create_response();
    }

    /**
     * Display the specified resource.
     *
     * @param CommissionHand $commissionHand
     * @return CommissionHand|Response
     */
    public function show(CommissionHand $commissionHand)
    {
        return new CommissionHand($commissionHand);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param CommissionHand $commissionHand
     * @return Response
     */
    public function update(Request $request, CommissionHand $commissionHand)
    {
        $request->validate($this->rules);

        $commissionHand->update($request->all());

        return update_response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CommissionHand $commissionHand
     * @return Response
     * @throws Exception
     */
    public function destroy(CommissionHand $commissionHand)
    {
        $commissionHand->delete();

        return delete_response();
    }
}
