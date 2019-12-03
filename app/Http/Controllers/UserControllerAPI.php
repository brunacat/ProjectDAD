<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\Request;
use App\User;
use Hash;

class UserControllerAPI extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:3',
            'nif' => 'required|integer|between:100000000,999999999|unique:users',
        ]);
        $user = new User();
        $user->fill($request->all());
        $user->password = Hash::make($user->password);
        $user->save();
    }

    public function getUser($email){

        $user = User::where('email', $email)->first();

        return response()->json($user);
    }
}
