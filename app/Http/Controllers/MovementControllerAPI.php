<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Resources\Movement as MovementResource;
use App\Movement;
use App\Wallet;

class MovementControllerAPI extends Controller
{
    public function addIncomeBT(Request $request)
    {
        if (Auth::user() &&  Auth::user()->type == "o") {
            $request->validate([
                'value' =>          'required|numeric|between:0,5000',
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
            $movement->source_description = $request->description;
            $wallet->balance += $request->value;

            $wallet->save();
            $movement->save();
        } else {
            return response()->json(['msg' => 'Unauthorized'], 401);
        }
    }

    public function addIncomeC(Request $request)
    {
        if (Auth::user() &&  Auth::user()->type == "o") {
            $request->validate([
                'value' =>          'required|numeric|between:0,5000',
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
            $movement->source_description = $request->description;
            $wallet->balance += $request->value;

            $wallet->save();
            $movement->save();

        } else {
            return response()->json(['msg' => 'Unauthorized'], 401);
        }
    }

    public function edit(Request $request)
    {
        if (Auth::user() && Auth::user()->type == "u") {
            $request->validate([
                'description' => 'max:256'
            ]);

            $movement = Movement::findOrFail($request->id);
            $movement->description = $request->description;
            $movement->category_id = $request->category;

            $movement->save();
        } else {
            return response()->json(['msg' => 'Unauthorized'], 401);
        }
    }
}
