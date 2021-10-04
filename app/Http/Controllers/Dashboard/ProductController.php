<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Requests\ProductUpdateRequest;
use Exception;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Resources\{ProductResource, ProductListResource, ProductSearchResource};
use Illuminate\Http\{Request, Resources\Json\AnonymousResourceCollection, Response};

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $product = Product::query();

        if($request->filled('query')){

            if(is_numeric($request->query('query'))){

                $product->where('id', $request->query('query'));
            }else{

                $product->where('name', 'like', "%{$request->query('query')}%");
            }

            return ProductSearchResource::collection($product->get());
        }

        if ($request->has('query')){
            return ProductSearchResource::collection(
                collect([])
            );
        }

        $product->with('supplier', 'brand')->withoutGlobalScope('publish');

        return ProductListResource::collection(
            $product->latest()->paginate(30)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductCreateRequest $request
     * @return Response
     */
    public function store(ProductCreateRequest $request)
    {
        $request->store();

        return create_response();
    }

    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return ProductResource
     */
    public function show($slug)
    {
        return new ProductResource(
            Product::with(['categories', 'deliveryModes', 'emi.installments', 'images'])
                ->withoutGlobalScope('publish')->whereSlug($slug)->firstOrFail()
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductUpdateRequest $request
     * @param $slug
     * @return Response
     */
    public function update(ProductUpdateRequest $request, $slug)
    {
        /** @var Product $product */
        $product = Product::query()->withoutGlobalScope('publish')
            ->where('slug', $slug)->firstOrFail();

        $request->update($product);

        return update_response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $slug
     * @return Response
     * @throws Exception
     */
    public function destroy($slug)
    {
        $product = Product::query()->withoutGlobalScope('publish')
            ->where('slug', $slug)
            ->firstOrFail();

        $product->delete();

        return delete_response();
    }
}
