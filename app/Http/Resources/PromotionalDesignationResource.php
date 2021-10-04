<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PromotionalDesignationResource extends JsonResource
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
            'stage' => $this->stage,
            'required_designation_name' => $this->requiredDesignation ? $this->requiredDesignation->name : 'New Member',
            'required_designation_number' => $this->required_designation,
            'required_designation_id' => $this->required_designation_id,
            'routes' => [
                'update' => route('admin.promotional-designations.update', $this),
                'destroy' => route('admin.promotional-designations.destroy', $this),
            ]
        ];
    }
}
