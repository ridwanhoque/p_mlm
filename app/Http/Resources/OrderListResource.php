<?php

namespace App\Http\Resources;

use App\Http\Controllers\Dashboard\OrderController;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderListResource extends JsonResource
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
            'user' => new UserResource($this->user),
            'total' => $this->total,
            'status' => [
                'raw' => $this->status,
                'text' => $this->status()
            ],
            'routes' => [
                'statusUpdate' => action([OrderController::class, 'updateStatus'], $this)
            ]
        ];
    }
}
