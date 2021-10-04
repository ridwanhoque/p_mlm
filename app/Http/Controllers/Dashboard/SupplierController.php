<?php

namespace App\Http\Controllers\Dashboard;

use Exception;
use App\Models\Supplier;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Http\Resources\SupplierResource;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\{Request, Resources\Json\AnonymousResourceCollection, Response};

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return SupplierResource::collection(
            Supplier::paginate()
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
        $request->validate([
            'name' => 'required|unique:suppliers'
        ]);

        Supplier::create($request->all());

        return create_response();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Supplier $supplier
     * @return ResponseFactory|Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required|unique:suppliers,name,'.$supplier->id
        ]);

        $supplier->update($request->all());

        return update_response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Supplier $supplier
     * @return Response
     * @throws Exception
     */
    public function destroy(Supplier $supplier)
    {
        try{
            $supplier->delete();
        }catch (QueryException $exception){
            abort(406, 'This supplier related other data.');
        }

        return delete_response();
    }
}
