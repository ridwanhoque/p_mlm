<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommissionHandResource extends JsonResource
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
            'label' => $this->label,
            'hand_level' => $this->hand_level,
            'commission' => $this->commission,
            'routes' => [
                'update' => route('admin.commission-hands.update', $this),
                'destroy' => route('admin.commission-hands.destroy', $this),
            ]
        ];
    }
}
