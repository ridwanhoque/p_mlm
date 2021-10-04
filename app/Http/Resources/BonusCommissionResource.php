<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BonusCommissionResource extends JsonResource
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
            'status' => $this->status(),
            'routes' => [
                'update' => route('admin.bonus-commissions.update', $this),
                'destroy' => route('admin.bonus-commissions.destroy', $this),
            ]
        ]);
    }
}
