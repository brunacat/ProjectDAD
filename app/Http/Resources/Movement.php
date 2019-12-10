<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Movement extends JsonResource
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
            'type' => $this->type,
            'transfer' => $this->transfer,
            'transfer_movement_id' => $this->transfer_movement_id,
            'transfer_wallet_id' => $this->transfer_wallet_id,
            'category_id' => $this->category_id,
            'date' => $this->date,
            'start_balance' => $this->start_balance,
            'end_balance' => $this->end_balance,
            'value' => $this->value
        ];
    }
}
