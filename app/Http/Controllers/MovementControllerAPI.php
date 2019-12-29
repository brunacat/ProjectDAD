<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Movement as MovementResource;
use App\Movement;
use App\Wallet;

class MovementControllerAPI extends Controller
{
    public function addIncomeBT(Request $request)
    {
        $request->validate([
            'value' =>          'required|between:0,5000',
            'description' =>    'max:256',
            'iban' =>           'required|regex:/[A-Z]{2}[0-9]{23}/',
            'email' =>          'required|exists:wallets'
        ]);

        $wallet = Wallet::where('email', $request->email)->firstOrFail();

        $movement = new Movement();
        $movement->wallet_id = $wallet->id;
        $movement->transfer = 0;
        $movement->type = "i";
        $movement->value = $request->value;
        $movement->date = now();
        $movement->start_balance = $wallet->balance;
        $movement->end_balance = $wallet->balance + $request->value;
        $movement->type_payment = $request->type;
        $movement->iban = $request->iban;
        $wallet->balance += $request->value;

        $wallet->save();
        $movement->save();
    }

    public function addIncomeC(Request $request)
    {
        $request->validate([
            'value' =>          'required|between:0,5000',
            'description' =>    'max:256',
            'email' =>          'required|exists:wallets'
        ]);

        $wallet = Wallet::where('email', $request->email)->firstOrFail();

        $movement = new Movement();
        $movement->wallet_id = $wallet->id;
        $movement->transfer = 0;
        $movement->type = "i";
        $movement->value = $request->value;
        $movement->date = now();
        $movement->start_balance = $wallet->balance;
        $movement->end_balance = $wallet->balance + $request->value;
        $movement->type_payment = $request->type;
        $wallet->balance += $request->value;

        $wallet->save();
        $movement->save();
    }
}
