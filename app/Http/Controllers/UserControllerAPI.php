<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\Request;

use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserSelf as UserSelfResource;
use App\Http\Resources\Wallet as WalletResource;
use App\User;
use App\Wallet;
use App\Movement;
use Hash;
use Illuminate\Support\Facades\Hash as FacadesHash;

class UserControllerAPI extends Controller
{
    public function index()
    {
    return UserResource::collection(User::all());   
    }

    public function show($id)
    {
        return new UserResource(User::find($id));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
            'email' => 'required|email|unique:users,email,',
            'password' => 'required|min:3',
            'nif' => 'required|integer|between:100000000,999999999|unique:users',
        ]);

        $user = new User();
        $user->fill($request->all());
        $user->password = Hash::make($user->password);
        $user->type = "u";
        $user->save();

        $wallet = new Wallet();
        $wallet->id = $user->id;
        $wallet->email = $user->email;
        $wallet->balance = "0";
        $wallet->save();
    }

    public function registerAO(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
            'email' => 'required|email|unique:users,email,',
            'password' => 'required|min:3',
            'type' => 'required'
        ]);

        $user = new User();
        $user->fill($request->all());
        $user->password = Hash::make($user->password);
        $user->save();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
            'nif' => 'required|integer|between:100000000,999999999|unique:users,nif,' . $id
        ]);
        $user = User::findOrFail($id);
        $user->update($request->all());
        return new UserSelfResource($user);
    }

    public function updatePass(Request $request, $id)
    {
        $request->validate([
            'oldPass' => 'required|min:3',
            'newPass' => 'required|min:3'
        ]);
        $user = User::findOrFail($id);

        if (Hash::check($request->oldPass, $user->password)) {
            $user->update([
                'password' => Hash::make($request->newPass)
            ]);
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(null, 204);
    }

    public function getUser($email)
    {
        $user = User::where('email', $email)->first();

        return response()->json($user);
    }

    public function myProfile(Request $request)
    {
        return new UserSelfResource($request->user());
    }

    public function addTransfer(Request $request, $id)
    {
        $request->validate([
            'value' => 'required|between:0,5000',
            'email' => 'required|exists:wallets',
            'description' => 'max:256'
        ]);

        $user = User::findOrFail($id);
        $wallet = Wallet::where('email', $user->email)->firstOrFail();
        $wallet2 = Wallet::where('email', $request->email)->firstOrFail();

        $movement1 = new Movement();
        $movement1->wallet_id = $wallet->id;
        $movement1->transfer = 1;
        $movement1->type = "e";
        $movement1->transfer_wallet_id = $wallet2->id;
        $movement1->category_id = $request->category;
        $movement1->source_description = $request->description;
        $movement1->value = $request->value;
        $movement1->date = now();
        $movement1->start_balance = $wallet->balance;
        $movement1->end_balance = $wallet->balance - $request->value;
        $wallet->balance -= $request->value;

        $movement2 = new Movement();
        $movement2->wallet_id = $wallet2->id;
        $movement2->transfer = 1;
        $movement2->type = "i";
        $movement2->transfer_wallet_id = $wallet->id;
        $movement2->category_id = $request->category;
        $movement2->source_description = $request->description;
        $movement2->value = $request->value;
        $movement2->date = now();
        $movement2->start_balance = $wallet2->balance;
        $movement2->end_balance = $wallet2->balance + $request->value;
        $wallet2->balance += $request->value;

        $movement1->save();
        $movement2->save();
        $movement1->transfer_movement_id = $movement2->id;
        $movement2->transfer_movement_id = $movement1->id;
        $movement1->save();
        $movement2->save();

        $wallet->save();
        $wallet2->save();

        return $wallet->balance;
    }
    public function addPaymentMB(Request $request, $id)
    {
        $request->validate([
            'value' =>          'required|between:0,5000',
            'description' =>    'max:256',
            'mbECode' =>        'required|regex:/[0-9]{5}/',
            'mbRef' =>          'required|regex:/[0-9]{9}/'
        ]);

        $user = User::findOrFail($id);
        $wallet = Wallet::where('email', $user->email)->firstOrFail();

        $movement = new Movement();
        $movement->wallet_id = $wallet->id;
        $movement->transfer = 0;
        $movement->type = "e";
        $movement->category_id = $request->category;
        $movement->value = $request->value;
        $movement->date = now();
        $movement->start_balance = $wallet->balance;
        $movement->end_balance = $wallet->balance - $request->value;
        $movement->type_payment = $request->type;
        $movement->mb_entity_code = $request->mbECode;
        $movement->mb_payment_reference = $request->mbRef;
        $wallet->balance -= $request->value;

        $wallet->save();
        $movement->save();

        return $wallet->balance;
    }

    public function addPaymentBT(Request $request, $id)
    {
        $request->validate([
            'value' =>          'required|between:0,5000',
            'description' =>    'max:256',
            'iban' =>           'required|regex:/[A-Z]{2}[0-9]{23}/',
        ]);

        $user = User::findOrFail($id);
        $wallet = Wallet::where('email', $user->email)->firstOrFail();

        $movement = new Movement();
        $movement->wallet_id = $wallet->id;
        $movement->transfer = 0;
        $movement->type = "e";
        $movement->category_id = $request->category;
        $movement->value = $request->value;
        $movement->date = now();
        $movement->start_balance = $wallet->balance;
        $movement->end_balance = $wallet->balance - $request->value;
        $movement->type_payment = $request->type;
        $movement->iban = $request->iban;
        $wallet->balance -= $request->value;

        $wallet->save();
        $movement->save();

        return $wallet->balance;
    }

    public function uploadImage(Request $request)
    {
        $request->photo->storeAs('public/fotos', $request->photo->getClientOriginalName());
    }
}
