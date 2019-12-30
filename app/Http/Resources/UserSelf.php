<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserSelf extends JsonResource
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
            'type' => $this->type,
            'active' => $this->active,
            'name' => $this->name,
            'email' => $this->email,
            'nif' => $this->nif,
            'balance' => $this->wallet ? $this->wallet->balance : "No wallet" ,
            'photo' => $this->photo
        ];
    }
}
