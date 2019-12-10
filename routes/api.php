<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('users', 'UserControllerAPI@index');

Route::post('login', 'LoginControllerAPI@login');
Route::middleware('auth:api')->post('logout', 'LoginControllerAPI@logout');

Route::get('wallets/total', 'WalletControllerAPI@total');
Route::post('user/register', 'UserControllerAPI@register');
Route::get('user/mail/{email}', 'UserControllerAPI@getUser');

Route::middleware('auth:api')->get('users/me', 'UserControllerAPI@myProfile');
Route::middleware('auth:api')->get('wallet/me', 'WalletControllerAPI@myWallet');

Route::get('users/{id}', 'UserControllerAPI@show');
Route::put('users/{id}', 'UserControllerAPI@update');
Route::delete('users/{id}', 'UserControllerAPI@destroy');

Route::middleware('auth:api')->get('wallet/me/movements', 'WalletControllerAPI@myMovements');
