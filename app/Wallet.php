<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
   protected $fillable = [
        'email', 'balance',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

     public function phone()
    {
        return $this->belongsTo('App\User');
    }


}
