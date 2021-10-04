<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\PackageUpdateRequest;
use App\Http\Resources\PackageResource;
use Exception;
use App\Models\Package;
use App\Http\Controllers\Controller;
use App\Http\Resources\PackageListResource;
use App\Http\Requests\PackageCreateRequest;
use Illuminate\Http\{Resources\Json\AnonymousResourceCollection, Response};

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return PackageListResource::collection(
            Package::query()->withoutGlobalScope('publish')->latest()->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PackageCreateRequest $request
     * @return Response
     */
    public function store(PackageCreateRequest $request)
    {
        $request->store();

        return create_response();
    }

    /**
     * Display the specified resource.
     *
     * @param Package $package
     * @return PackageResource|Response
     */
    public function show($package)
    {
        return new PackageResource(
            $this->getPackage($package)->load('products', 'categories', 'deliveryModes', 'emi.installments')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PackageUpdateRequest $request
     * @param Package $package
     * @return Response
     */
    public function update(PackageUpdateRequest $request, $package)
    {
        $package = $this->getPackage($package);

        $request->update($package);

        return update_response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Package $package
     * @return Response
     * @throws Exception
     */
    public function destroy($package)
    {
        $package = $this->getPackage($package);

        $package->delete();

        return delete_response();
    }

    protected function getPackage($slug) : Package
    {
        return Package::query()
            ->withoutGlobalScope('publish')->where('slug', $slug)->firstOrFail();
    }
}
