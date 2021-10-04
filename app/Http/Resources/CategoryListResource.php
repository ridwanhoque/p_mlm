<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'parent_id' => $this->parent_id,
            'image' => $this->image(),
            'is_featured' => $this->is_featured,
            'show_on_home' => $this->show_on_home,
            'slug' => $this->slug,
            'routes' => [
                'update' => route('admin.categories.update', $this),
                'destroy' => route('admin.categories.destroy', $this),
            ]
        ];
    }
}
