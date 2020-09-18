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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/homeOFF', 'HomeController@index')->name('homeOFF');

Route::resource('/estadisticas', 'StadisticController');

Route::resource('/cocodrileras', 'Servicios\CocodrileraController');
Route::resource('/rcocodrileras', 'Reservas\ReservaCocodrileraController');


//*AJAXS*//
Route::get('/dispococo9params/{nameForm}/{cocodrileraForm}/{mercadoForm}/{totalForm}/{nacForm}/{planForm}/{fechaEForm}/{fechaSForm}/{activaForm}',
        'Reservas\ReservaCocodrileraController@DispoCOCO9params')->name('api.dispococo9params');
Route::get('/dispococo11params/{nameForm}/{cocodrileraForm}/{mercadoForm}/{totalForm}/{nacForm}/{planForm}/{fechaEForm}/{fechaSForm}/{adultos}/{menores}/{activaForm}',
        'Reservas\ReservaCocodrileraController@DispoCOCO11params')->name('api.dispococo11params');
Route::get('/dispococo12params/{nameForm}/{cocodrileraForm}/{mercadoForm}/{totalForm}/{nacForm}/{planForm}/{fechaEForm}/{fechaSForm}/{adultos}/{menores}/{agenciaForm}/{activaForm}',
        'Reservas\ReservaCocodrileraController@DispoCOCO12params')->name('api.dispococo12params');


Route::get('/dispo/{nameForm}/{cocodrileraForm}/{mercadoForm}/{totalForm}/{nacForm}/{planForm}/{fechaEForm}/{fechaSForm}/{activaForm}',
        'Reservas\ReservaCocodrileraController@dispo')->name('api.dispo');
Route::get('/onedaydispo/{nameForm}/{cocodrileraForm}/{mercadoForm}/{totalForm}/{nacForm}/{planForm}/{fechaEForm}/{fechaSForm}/{activaForm}',
        'Reservas\ReservaCocodrileraController@onedaydispo')->name('onedaydispo');

