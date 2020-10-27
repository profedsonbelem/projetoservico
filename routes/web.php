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


Route::get('api/findAll',['uses'=>'ClienteController@findAll']);
Route::get('api/findById/{id}',['uses'=>'ClienteController@findById']);

Route::post('api/save', ['uses'=>'ClienteController@create'] );

Route::put('api/update/{id}', ['uses'=>'ClienteController@update'] );

Route::delete('api/delete/{id}', ['uses'=>'ClienteController@delete'] );