<?php

use App\Http\Controllers\PadronController;
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



Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('signup', 'AuthController@signup');

    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('authenticated-user-data', 'AuthController@authenticatedUserData');
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});

Route::group(['prefix' => 'contract', 'middleware' => 'auth:api'],function()
{
    Route::post('store', 'ContractController@Store');
    Route::get('index', 'ContractController@Index');
    Route::get('getContractbyID/{id}', 'ContractController@getContractbyID');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
