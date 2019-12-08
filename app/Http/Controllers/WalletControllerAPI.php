<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Resources\Wallet as WalletResource;
use App\Wallet;


class WalletControllerAPI extends Controller
{
	public function total()
    {
     $total = Wallet::count();
     return response()->json($total);
    }

    public function myWallet(Request $request)
    {
        return new WalletResource($request->user()->wallet);
    }
}
