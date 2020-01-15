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
            'id' =>$this->id,
            'type' => $this->getType($this->type),
            'transfer' => $this->transfer ? "Transfer" : "Other",
            'email' => $this->transfer_movement_id ? $this->getWalletEmail($this->transfer_wallet_id) : "Not a transfer",
            'transfer_movement_id' => $this->transfer_movement_id,
            'transfer_wallet_id' => $this->transfer_wallet_id,
            'type_payment' => $this->transfer ?  "Not a Payment" : $this->getTypePayment($this->type_payment),
            'category' => $this->category ? $this->category->name : "No category",
            'date' => $this->date,
            'start_balance' => $this->start_balance,
            'end_balance' => $this->end_balance,
            'value' => $this->type == "i" ? "$this->value €" :  "($this->value €)",
            'iban' => $this->when($this->iban, $this->iban),
            'mb_entity_code' => $this->when($this->mb_entity_code,$this->mb_entity_code),
            'mb_payment_reference' => $this->when($this->mb_payment_reference,$this->mb_payment_reference),
            'description' => $this->when($this->description,$this->description),
            'source_description' => $this->when($this->source_description,$this->source_description),
            'photo' => $this->transfer_movement_id ? ($this->getPhoto($this->transfer_wallet_id) ? $this->getPhoto($this->transfer_wallet_id) : "No image"): "Not a transfer"
        ];
    }
}
