<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\Request;

use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserSelf as UserSelfResource;
use App\Http\Resources\Wallet as WalletResource;
use App\User;
use App\Wallet;
use Hash;
use Illuminate\Support\Facades\Hash as FacadesHash;

class UserControllerAPI extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('page')) {
            return UserResource::collection(User::paginate(5));
        } else {
            return UserResource::collection(User::all());
        }

        /*Caso não se pretenda fazer uso de Eloquent API Resources (https://laravel.com/docs/5.5/eloquent-resources), é possível implementar com esta abordagem:
        if ($request->has('page')) {
            return User::with('department')->paginate(5);;
        } else {
            return User::with('department')->get();;
        }*/
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
            'nif' => 'required|integer|between:100000000,999999999|unique:users,nif,' .$id
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

    public function uploadImage(Request $request)
    {
        $request->photo->storeAs('public/fotos', $request->photo->getClientOriginalName());
    }
}
