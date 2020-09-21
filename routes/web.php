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

#servicios
Route::resource('cocodrileras', 'Servicios\CocodrileraController');

#reservas
Route::resource('ralojamientos', 'Reservas\ReservaCocodrileraController');
Route::resource('rcocodrileras', 'Reservas\ReservaCocodrileraController');
Route::resource('recuestres', 'Reservas\ReservaCocodrileraController');
Route::resource('reventos', 'Reservas\ReservaCocodrileraController');
Route::resource('rexcursiones', 'Reservas\ReservaCocodrileraController');
Route::resource('rfluviales', 'Reservas\ReservaCocodrileraController');
Route::resource('rgastronomias', 'Reservas\ReservaCocodrileraController');
Route::resource('rnauticas', 'Reservas\ReservaCocodrileraController');
Route::resource('robs', 'Reservas\ReservaCocodrileraController');
Route::resource('rofertas', 'Reservas\ReservaCocodrileraController');
Route::resource('rsafaris', 'Reservas\ReservaCocodrileraController');
Route::resource('rsenderos', 'Reservas\ReservaCocodrileraController');
Route::resource('rvallas', 'Reservas\ReservaCocodrileraController');

#otros
Route::resource('provincias', 'ProvinciaController');

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


//reportes
Route::get('reportes', 'ReporteController@index')->name('reportes.index');