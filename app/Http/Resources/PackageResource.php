<?php

namespace App\Http\Resources;

use Illuminate\Http\{Request, Resources\Json\JsonResource};

class PackageResource extends JsonResource
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
            'slug' => $this->slug,
            'name' => $this->name,
            'sale_price' => $this->sale_price,
            'discount_percentage' => $this->discount_percentage,
            'discount_amount' => $this->discount_amount,
            'discount_start_date' => $this->discount_start_date,
            'discount_end_date' => $this->discount_end_date,
            'commission' => $this->commission,
            'a_delivery_charge_dhaka' => $this->a_delivery_charge_dhaka,
            'a_delivery_charge_out_of_dhaka' => $this->a_delivery_charge_out_of_dhaka,
            'delivery_time_dhaka' => $this->delivery_time_dhaka,
            'delivery_time_out_of_dhaka' => $this->delivery_time_out_of_dhaka,
            'priority' => $this->priority,
            'comments' => $this->comments,
            'cash_back' => $this->cash_back,
            'nb' => $this->nb,
            'position' => $this->position,
            'emi_available' => $this->emi_available,
            'is_publish' => (bool) $this->publish_at,
            'show_on_home' => (bool) $this->show_on_home,
            'products' => ProductSearchResource::collection($this->products),
            'categories' => $this->categories,
            'delivery_modes' => $this->deliveryModes,
            'images' => $this->images,
            'emi' => $this->emi,
            'routes' => [
                'update' => route('admin.packages.update', $this)
            ]
        ];
    }
}
