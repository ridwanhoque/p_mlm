<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Resources\PromotionalDesignationResource;
use App\Http\Resources\ReferenceUserResource;
use App\Models\PromotionalDesignation;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class PromotionalDesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return PromotionalDesignation[]|Collection|AnonymousResourceCollection|Response
     */
    public function index()
    {
        return PromotionalDesignationResource::collection(
            PromotionalDesignation::with('requiredDesignation')
                ->get()
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
            'name' => 'required|unique:promotional_designations',
            'stage' => 'required|integer',
            'required_designation' => 'required|integer',
            'required_designation_id' => 'nullable|exists:promotional_designations,id'
        ]);

        PromotionalDesignation::create($attributes);

        return create_response();
    }

    /**
     * Display the specified resource.
     *
     * @param PromotionalDesignation $promotionalDesignation
     * @return PromotionalDesignationResource|Response
     */
    public function show(PromotionalDesignation $promotionalDesignation)
    {
        return new PromotionalDesignationResource(
            $promotionalDesignation
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param PromotionalDesignation $promotionalDesignation
     * @return Response
     */
    public function update(Request $request, PromotionalDesignation $promotionalDesignation)
    {
        $attributes = $request->validate([
            'name' => 'required|unique:promotional_designations,name,' . $promotionalDesignation->id,
            'stage' => 'required|integer',
            'required_designation' => 'required|integer',
            'required_designation_id' => 'nullable|exists:promotional_designations,id'
        ]);

        $promotionalDesignation->update($attributes);

        return update_response();
    }

    public function users(PromotionalDesignation $promotionalDesignation, User $user)
    {
        $users = $promotionalDesignation->users()->with('designation')->withCount([
            'childs as register_count' => function(Builder $builder){
                $builder->registered();
            },
            'childs as unregister_count' => function(Builder $builder){
                $builder->unRegistered();
            },
        ]);

        $users->whereIn('id', $user->childs()->pluck('users.id')->toArray());

        return ReferenceUserResource::collection(
            $users->get()
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PromotionalDesignation $promotionalDesignation
     * @return Response
     * @throws Exception
     */
    public function destroy(PromotionalDesignation $promotionalDesignation)
    {
        $promotionalDesignation->delete();

        return delete_response();
    }
}
