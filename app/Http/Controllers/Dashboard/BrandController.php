<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Intervention\Image\Facades\Image;

class BrandController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $brand = Brand::query();

        if($request->has('all')){
            $brand = $brand->get();
        }else{
            $brand = $brand->paginate();
        }

        return BrandResource::collection(
            $brand
        );
    }

    /**
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required|unique:brands',
            'logo' => 'required|image'
        ]);

        $attributes['logo'] = file_path($request->file('logo')->hashName());

        $this->resizeImage($request->file('logo'), 'uploads/'.$attributes['logo']);

        Brand::create($attributes);

        return create_response();
    }

    /**
     * @param Request $request
     * @param Brand $brand
     * @return ResponseFactory|Response
     */
    public function update(Request $request, Brand $brand)
    {
        $attributes = $request->validate([
            'name' => 'required|unique:brands,name,' . $brand->id,
            'logo' => 'image'
        ]);

        Arr::forget($attributes, 'logo');

        if($request->hasFile('logo')){
            $this->resizeImage($request->file('logo'), ltrim($brand->logo(), '/'));
        }

        $brand->update($attributes);

        return update_response();
    }

    public function destroy(Brand $brand)
    {
        try{
            $brand->delete();
        }catch (QueryException $exception){
            abort(406, 'This brand related on other data!');
        }

        return delete_response();
    }

    protected function resizeImage($file, $fileName)
    {
        Image::make($file)->resize(200, 200)
        ->save($fileName);
    }
}
