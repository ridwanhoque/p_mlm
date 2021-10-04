<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
            'item' => $this->orderable,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'commission' => $this->commission,
            'item_type' => $this->orderable
        ];
    }
}
