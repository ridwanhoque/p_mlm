<?php

namespace App\Http\Resources;

use Illuminate\Http\{Request, Resources\Json\JsonResource};

class CourseListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price,
            'publish' => $this->publish[$this->is_publish],
            'routes' => [
                'update' => route('admin.courses.update', $this),
                'destroy' => route('admin.courses.destroy', $this),
            ]
        ];
    }
}
