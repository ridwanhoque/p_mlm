<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageListResource extends JsonResource
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
            'slug' => $this->slug,
            'publish_at' => optional($this->publish_at)->format('d F, Y'),
            'routes' => [
                'update' => route('admin.packages.update', $this),
                'destroy' => route('admin.packages.destroy', $this),
            ]
        ];
    }
}
