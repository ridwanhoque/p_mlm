<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseListResource extends JsonResource
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
            'supplier' => [
                'name' => $this->supplier->name
            ],
            'total' => $this->total,
            'paid' => $this->paid(),
            'due' => ($this->total - $this->paid()),
            'routes' => [
                'destroy' => route('admin.purchases.destroy', $this)
            ]
        ];
    }
}
