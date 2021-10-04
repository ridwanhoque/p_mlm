<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmiPlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request) + [
                'routes' => [
                    'update' => route('admin.emi-plans.update', $this),
                    'destroy' => route('admin.emi-plans.destroy', $this),
                ]
            ];
    }
}
