<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Resources\EmiPlanResource;
use App\Models\EmiPlan;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\{Request, Resources\Json\AnonymousResourceCollection, Response};

class EmiPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection|Response
     */
    public function index()
    {
        return EmiPlanResource::collection(
            EmiPlan::all()
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
            'name' => 'required|unique:emi_plans',
            'installment' => 'required|numeric|min:1',
            'interest' => 'numeric'
        ]);

        EmiPlan::create($attributes);

        return create_response();
    }

    /**
     * Display the specified resource.
     *
     * @param EmiPlan $emiPlan
     * @return Response
     */
    public function show(EmiPlan $emiPlan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param EmiPlan $emiPlan
     * @return Response
     */
    public function update(Request $request, EmiPlan $emiPlan)
    {
        $attributes = $request->validate([
            'name' => 'required|unique:emi_plans,name,' . $emiPlan->id,
            'installment' => 'required|min:1',
            'interest' => 'numeric'
        ]);

        $emiPlan->update($attributes);

        return update_response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param EmiPlan $emiPlan
     * @return Response
     * @throws Exception
     */
    public function destroy(EmiPlan $emiPlan)
    {
        try{
            $emiPlan->delete();
        }catch (QueryException $exception){
            abort(406, 'This plan related other items. Please delete those first!');
        }

        return delete_response();
    }
}
