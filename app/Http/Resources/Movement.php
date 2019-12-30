<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Wallet;

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
            'id' =>$this->id,
            'type' => $this->getType($this->type),
            'transfer' => $this->transfer ? "Tranfer" : "Other",
            'transfer_movement_id' => $this->transfer_movement_id,
            'transfer_wallet_id' => $this->transfer_wallet_id,
            'type_payment' => $this->transfer ? $this->getTypePayment($this->type_payment) : "Not a Payment",
            'category' => $this->category ? $this->category->name : "No category",
            'date' => $this->date,
            'start_balance' => $this->start_balance,
            'end_balance' => $this->end_balance,
            'value' => $this->value,
            'iban' => $this->iban,
            'mb_entity_code' => $this->mb_entity_code,
            'mb_payment_reference' => $this->mb_payment_reference,
            'description' => $this->description,
            'source_description' => $this->source_description
        ];
    }
}
