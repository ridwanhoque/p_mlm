<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Slide;
use App\Http\Resources\SlideResource;
use App\Http\Controllers\Controller;
use App\Repositories\SlideRepository;
use Exception;
use Illuminate\Http\{Request, Resources\Json\AnonymousResourceCollection, Response};
use Illuminate\Support\Arr;

class SlideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection|Response
     */
    public function index()
    {
        return SlideResource::collection(
            Slide::all()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param SlideRepository $slideRepository
     * @return Response
     */
    public function store(Request $request, SlideRepository $slideRepository)
    {
        $attributes = $request->validate([
            'title' => 'required',
            'image' => 'required|image'
        ]);

        $attributes['image'] = $request->file('image')->store(file_path());

        Slide::create($attributes + [
                'link' => $request->link,
                'button_text' => $request->button_text,
                'description' => $request->description
            ]
        );

        $slideRepository->forgetSlides();

        return create_response();
    }

    /**
     * Display the specified resource.
     *
     * @param Slide $slide
     * @return Response
     */
    public function show(Slide $slide)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Slide $slide
     * @param SlideRepository $slideRepository
     * @return Response
     */
    public function update(Request $request, Slide $slide, SlideRepository $slideRepository)
    {
        $attributes = $request->validate([
            'title' => 'required',
            'image' => 'image'
        ]);

        Arr::forget($attributes, 'image');

        if($request->hasFile('image')){
            $request->file('image')->storeAs(
                dirname($slide->image), basename($slide->image)
            );
        }

        $slide->update($attributes + [
                'link' => $request->link,
                'button_text' => $request->button_text,
                'description' => $request->description
            ]
        );

        $slideRepository->forgetSlides();

        return update_response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Slide $slide
     * @param SlideRepository $slideRepository
     * @return Response
     * @throws Exception
     */
    public function destroy(Slide $slide, SlideRepository $slideRepository)
    {
        $slide->delete();

        $slideRepository->forgetSlides();

        return delete_response();
    }
}
