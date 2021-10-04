<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductListResource extends JsonResource
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
            'slug' => $this->slug,
            'name' => $this->name,
            'publish' => $this->publish[$this->is_publish],
            'brand' => [
                'name' => $this->brand->name
            ],
            'supplier' => [
                'name' => $this->supplier->name
            ],
            'routes' => [
                'update' => route('admin.products.update', $this),
                'destroy' => route('admin.products.destroy', $this),
            ]
        ];
    }
}
