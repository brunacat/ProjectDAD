<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
   protected $fillable = [
        'email', 'balance'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'id');
    }

    public function movements()
    {
        return $this->hasMany('App\Movement');
    }

    public function transfers()
    {
        return $this->hasMany('App\Movement', 'transfer_wallet_id');
    }

}
