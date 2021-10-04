<?php

namespace App\Http\Resources\Portal;

use Illuminate\Http\Resources\Json\JsonResource;

class JoiningProductResource extends JsonResource
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
            'category' => [
                'top' => $this->immediateCategory->parents[0]
            ],
            'price' => [
                'previous' => (float) $this->previousPrice,
                'discount' => (float) $this->discountAmount,
                'present' => (float) $this->price(false)
            ],
            'commission' => (float) $this->commission,
            'routes' => [
                'permalink' => $this->permalink()
            ]
        ];
    }
}
