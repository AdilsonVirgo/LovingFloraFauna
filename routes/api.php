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
#region Servicios
Route::get('/cocodrilera/{id}', 'API\ServiciosAPIController@cocodrilera')->name('api.cocodrilera');
Route::get('/cocodrileras', 'API\ServiciosAPIController@cocodrileras')->name('api.cocodrileras');
#endregion

#region Reservas
Route::get('/rcocodrilera/{id}', 'API\ReservasAPIController@rcocodrilera')->name('api.rcocodrilera');
Route::get('/rcocodrileras', 'API\ReservasAPIController@rcocodrileras')->name('api.rcocodrileras');
#endregion

#region Nomencladores
Route::get('/mercado/{id}', 'API\NomencladoresAPIController@mercado')->name('api.mercado');
Route::get('/mercados', 'API\NomencladoresAPIController@mercados')->name('api.mercados');
Route::get('/nacionalidad/{id}', 'API\NomencladoresAPIController@nacionalidad')->name('api.nacionalidad');
Route::get('/nacionalidades', 'API\NomencladoresAPIController@nacionalidades')->name('api.nacionalidades');
Route::get('/agencia/{id}', 'API\NomencladoresAPIController@agencia')->name('api.agencia');
Route::get('/agencias', 'API\NomencladoresAPIController@agencias')->name('api.agencias');
#endregion

//Route::get('/dispococo/{id}/{id2}/{id3}/{id4}/{id5}/{id6}/{id7}/{id8}/{id9}',
//        'Reservas\ReservaCocodrileraController@DispoCOCO')->name('api.dispococo');
