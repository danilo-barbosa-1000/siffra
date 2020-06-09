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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});*/


Route::middleware('guest:api')->post('/login','UserController@login')->name('login');
Route::middleware('auth:api')->post('/logout','UserController@logout')->name('logout');

Route::prefix('users')->group(function(){
	Route::get('/','UserController@index');
	Route::get('/{id}','UserController@show');
	Route::post('/','UserController@store');
	Route::put('/{id}','UserController@update');
	Route::delete('/{id}','UserController@delete');
});//->middleware('auth:api');