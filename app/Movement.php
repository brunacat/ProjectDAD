<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    protected $fillable = [
        'wallet_id', 'transfer', 'transfer_movement_id', 'transfer_wallet_id', 'type_payment', 'category_id', 'iban',
        'mb_entity_code', 'mb_payment_reference', 'description', 'source_description', 'start_balance', 'end_balance', 'value'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'datetime'
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function par_movement()
    {
        return $this->hasOne('App\Movement', 'transfer_movement_id');
    }
}
