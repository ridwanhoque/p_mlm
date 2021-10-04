<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryCenterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'routes' => [
                'update' => route('admin.delivery-centers.update', $this),
                'destroy' => route('admin.delivery-centers.destroy', $this)
            ]
        ]);
    }
}
