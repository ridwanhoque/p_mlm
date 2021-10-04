<?php

namespace App\Http\Controllers\Dashboard;

use Exception;
use App\Models\Category;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use App\Repositories\CategoryRepository;
use App\Http\Resources\{CategoryResource, CategoryListResource};
use Illuminate\Http\{Request, Resources\Json\AnonymousResourceCollection, Response};

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $category = Category::query();

        if($request->filled('parent_id')){
            $category->where('parent_id', $request->parent_id);
        }else{
            $category->root();
        }

        if($request->has('all')){
            return CategoryResource::collection(
                $category->get()
            );
        }

        return CategoryListResource::collection($category->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function store(Request $request, CategoryRepository $categoryRepository)
    {
        $attributes = $request->validate([
            'name' => 'required|unique:categories',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => ['required', 'image', Rule::dimensions()->height(300)->width(300)],
            'is_featured' => 'nullable|boolean',
            'show_on_home' => 'nullable|boolean',
        ]);

        $attributes['image'] = $request->file('image')->store(file_path());

        Category::create($attributes);

        $categoryRepository->forgetAll();

        return create_response();
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return CategoryResource
     */
    public function show($id)
    {
        /** @var Category $category */
        $category = Category::query()
            ->findOrFail($id);

        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Category $category
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function update(Request $request, Category $category, CategoryRepository $categoryRepository)
    {
        $attributes = $request->validate([
            'name' => 'required|unique:categories,name,'.$category->id,
            'parent_id' => 'nullable|exists:categories,id',
            'image' => ['image', Rule::dimensions()->width(300)->height(300)]
        ]);

        Arr::forget($attributes, 'image');

        if($request->hasFile('image')){
            $request->file('image')
                ->storeAs(dirname($category->image), basename($category->image));
        }

        $attributes['is_featured'] = $request->get('is_featured', 0);
        $attributes['show_on_home'] = $request->get('show_on_home', 0);

        $category->update($attributes);

        $categoryRepository->forgetFeatured();

        return update_response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @param CategoryRepository $categoryRepository
     * @return void
     * @throws Exception
     */
    public function destroy(Category $category, CategoryRepository $categoryRepository)
    {
        try{
            $category->delete();
        }catch (QueryException $exception){
            abort(406, 'This category related other data!');
        }

        $categoryRepository->forgetAll();

        return delete_response();
    }
}
