<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Course;
use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Http\Resources\{CourseListResource, CourseResource};
use App\Http\Requests\{CourseCreateRequest, CourseUpdateRequest};

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return CourseListResource::collection(
            Course::query()->withoutGlobalScope('publish')
                ->latest()->paginate()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CourseCreateRequest $request
     * @return Response
     */
    public function store(CourseCreateRequest $request)
    {
        $request->store();

        return create_response();
    }

    /**
     * Display the specified resource.
     *
     * @param Course $course
     * @return CourseResource
     */
    public function show($course)
    {
        $course = Course::with('modules')->withoutGlobalScope('publish')
            ->where('slug', $course)->firstOrFail();

        return new CourseResource(
            $course
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CourseUpdateRequest $request
     * @param Course $course
     * @return ResponseFactory|Response
     */
    public function update(CourseUpdateRequest $request, $course)
    {
        /** @var Course $course */
        $course = Course::query()->withoutGlobalScope('publish')
            ->where('slug', $course)->firstOrFail();

        $request->update($course);

        return update_response();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Course $course
     * @return Response
     * @throws Exception
     */
    public function destroy($course)
    {
        $course = Course::query()->withoutGlobalScope('publish')
            ->where('slug', $course)->firstOrFail();

        $course->delete();

        return delete_response();
    }
}
