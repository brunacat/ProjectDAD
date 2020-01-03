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

Route::middleware('auth:api')->get('users', 'UserControllerAPI@index');
Route::middleware('auth:api')-> get('categories', 'CategoryControllerAPI@list');

Route::post('login', 'LoginControllerAPI@login');
Route::middleware('auth:api')->post('logout', 'LoginControllerAPI@logout');

Route::get('wallets/total', 'WalletControllerAPI@total');
Route::post('user/register', 'UserControllerAPI@register');
Route::middleware('auth:api')->post('user/register-ao', 'UserControllerAPI@registerAO');
Route::middleware('auth:api')->get('user/mail/{email}', 'UserControllerAPI@getUser');

Route::middleware('auth:api')->get('users/me', 'UserControllerAPI@myProfile');
Route::middleware('auth:api')->get('wallet/me', 'WalletControllerAPI@myWallet');
Route::middleware('auth:api')->get('userByEmail/{email}', 'UserControllerAPI@findUserByEmail');


Route::middleware('auth:api')->put('users/{id}', 'UserControllerAPI@update');
Route::middleware('auth:api')->post('transfer/{id}', 'UserControllerAPI@addTransfer');
Route::middleware('auth:api')->post('paymentMB/{id}', 'UserControllerAPI@addPaymentMB');
Route::middleware('auth:api')->post('paymentBT/{id}', 'UserControllerAPI@addPaymentBT');

Route::middleware('auth:api')->post('incomeBT', 'MovementControllerAPI@addIncomeBT');
Route::middleware('auth:api')->post('incomeC', 'MovementControllerAPI@addIncomeC');

Route::middleware('auth:api')->put('users/pass/{id}', 'UserControllerAPI@updatePass');
Route::middleware('auth:api')->delete('users/{id}', 'UserControllerAPI@destroy');

Route::middleware('auth:api')->put('movementsEdit', 'MovementControllerAPI@edit');
Route::middleware('auth:api')->get('wallet/me/movements', 'WalletControllerAPI@myMovements');

Route::post('upload-image', 'UserControllerAPI@uploadImage');
Route::post('sendEmail', 'EmailControllerAPI@send');