<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\Request;

use App\Http\Resources\User as UserResource;

use App\User;
use Hash;
use Image;

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

        $photo = $user->photo;
        $base=base64_decode($photo);
        $filename = time() . '.' . $photo[11].$photo[12].$photo[13].$photo[14].$photo[15];
        Image::make($base)->resize(300, 300)->save('/storage/app/public/fotos/', $filename);

        $user->save();
    }

    public function getUser($email){

        $user = User::where('email', $email)->first();

        return response()->json($user);
    }

    public function myProfile(Request $request)
    {
        return new UserResource($request->user());
    }
}
