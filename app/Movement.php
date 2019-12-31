<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Wallet;
use App\User;

class Movement extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'wallet_id', 'transfer', 'transfer_movement_id', 'transfer_wallet_id', 'type_payment', 'category_id', 'iban',
        'mb_entity_code', 'mb_payment_reference', 'description', 'source_description', 'start_balance', 'end_balance', 'value', 'date'
    ];

    public function wallet()
    {
        return $this->belongsTo('App\Wallet');
    }

    public function getType()
    {
        switch ($this->type) {
            case "e":
                return "Expense";
            case "i":
                return "Income";
        }
    }
    public function getTypePayment()
    {
        switch ($this->type_payment) {
            case "c":
                return "Cash";
            case "mb":
                return "MB Payment";
            case "bt":
                return "Bank Transfer";
        }
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function par_movement()
    {
        return $this->hasOne('App\Movement', 'transfer_movement_id');
    }

    public function getWalletEmail(int $id)
    {
       return Wallet::where('id', $id)->firstOrFail()->email;
    }

    public function getPhoto(int $id)
    {
       $email = Wallet::where('id', $id)->firstOrFail()->email;
       return User::where('email', $email)->firstOrFail()->photo;
    }
}
