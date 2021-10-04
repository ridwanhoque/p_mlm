<?php

namespace App\Http\Requests;

use App\Models\Course;
use Illuminate\Foundation\Http\FormRequest;

class CourseUpdateRequest extends FormRequest
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

    public function update(Course $course)
    {
        $course->update($this->all());

        $course->syncModules($this->get('modules', []));

        $this->uploadImages($course);
    }

    protected function uploadImages(Course $course)
    {
        foreach ($this->file('images', []) as $image){

            $course->images()->create([
                'path' => $image->store(file_path())
            ]);
        }
    }


}
