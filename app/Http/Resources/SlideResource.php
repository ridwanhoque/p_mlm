<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SlideResource extends JsonResource
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
            'title' => $this->title,
            'button_text' => $this->button_text,
            'link' => $this->link,
            'image' => $this->path(),
            'type' => $this->type,
            'description' => $this->description,
            'routes' => [
                'update' => route('admin.slides.update', $this),
                'destroy' => route('admin.slides.destroy', $this),
            ]
        ];
    }
}
