<?php

namespace App\Http\Requests;

use App\Models\Course;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class CourseCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'modules' => 'required',
            'modules.*.name' => 'required|distinct',
            'price' => 'required|numeric'
        ];
    }

    public function store()
    {
        /** @var Course $course */
        $course = Course::create($this->all());

        $course->syncCategories($this->categories);

        /** @var UploadedFile $image */
        foreach ($this->file('images', []) as $image){
            $course->images()->create([
                'path' => $image->store(file_path())
            ]);
        }

        $course->modules()->createMany($this->get('modules', []));
    }
}
