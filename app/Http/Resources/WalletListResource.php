<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WalletListResource extends JsonResource
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
            'amount' => $this->amount,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->fullName()
            ],
            'transaction_from' => $this->transactionFrom(),
            'created_at' => $this->created_at->format('d F, Y h:i A'),
            'status' => [
                'text' => $this->processStatus(),
                'class_name' => $this->processStatus('class')
            ]
        ];
    }
}
