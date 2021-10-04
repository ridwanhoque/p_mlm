<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReferenceUserResource extends JsonResource
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
            'name' => $this->fullName(),
            'email' => $this->email,
            'designation' => $this->when($this->designation, function (){
                return [
                    'id' => $this->designation->id,
                    'name' => $this->designation->name,
                    'stage' => $this->designation->stage
                ];
            }),
            'members' => [
                'register' => $this->register_count,
                'unregister' => $this->unregister_count,
                'total' => ($this->register_count + $this->unregister_count)
            ]
        ];
    }
}
