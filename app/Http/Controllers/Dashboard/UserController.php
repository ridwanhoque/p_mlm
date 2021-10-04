<?php

namespace App\Http\Controllers\Dashboard;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use App\Models\{PromotionalDesignation, User};
use App\Http\Resources\{DesignationResource, ReferenceUserResource, UserResource};

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param User|null $user
     * @return ReferenceUserResource|Response
     */
    public function show(?User $user)
    {
        $user = $user->exists ? $user : auth()->user();

        $user->load('designation')->loadCount([
            'childs as register_count' => function(Builder $builder){

                $builder->registered();
            },
            'childs as unregister_count' => function(Builder $builder){
                $builder->unRegistered();
            }
        ]);

        $designations = PromotionalDesignation::withCount(['users' => function(Builder $builder) use($user){
            $builder->whereIn('id', $user->childs()->pluck('id')->toArray());
        }])->whereNotNull('required_designation_id')->get();


        return (new ReferenceUserResource($user))->additional([
            'designations' => DesignationResource::collection($designations)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return void
     */
    public function destroy(User $user)
    {
        //
    }


    /**
     * @return UserResource
     */
    public function __invoke()
    {
        return new UserResource(
            auth()->user()
        );
    }
}
