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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('asistencia','asistenciaController');
Route::get('/getUserInforation/{userId}', 'asistenciaController@getUserInforation')->name('getUserInforation');
Route::post('/getEntradasSalidas', 'asistenciaController@getEntradasSalidas')->name('getEntradasSalidas');
Route::post('/registrarEntradasSalidas', 'asistenciaController@registrarEntradasSalidas')->name('registrarEntradasSalidas');
Route::get('/getMetadataByGroup/{group}', 'asistenciaController@getMetadataByGroup')->name('getMetadataByGroup');
Route::get('/getAllESRegisters', 'asistenciaController@getAllESRegisters')->name('getAllESRegisters');
Route::get('/getESRegistersByUsId/{usId}', 'asistenciaController@getESRegistersByUsId')->name('getESRegistersByUsId');






