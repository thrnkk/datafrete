<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/ceps', '\App\Http\Controllers\CEPController@index');
Route::post('/ceps', '\App\Http\Controllers\CEPController@store');
Route::delete('/ceps/{id}', '\App\Http\Controllers\CEPController@destroy');
Route::put('/ceps/{id}', '\App\Http\Controllers\CEPController@update');

Route::get('/api/cep/{cep}', '\App\Http\Controllers\ApiController@checkCEP');
Route::post('/api/cep/calculate/distance', '\App\Http\Controllers\ApiController@calculateDistance');
