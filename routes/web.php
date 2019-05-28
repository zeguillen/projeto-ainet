<?php

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

Route::get('/home', 'HomeController@index')->name('home');
Auth::routes(['verify' => true, 'register' => false]);

//password
Route::get('/password', 'UserController@changePassword')->name('password.change');
Route::patch('/password', 'UserController@savePassword')->name('password.save');

//socios
Route::middleware('auth', 'verified')->get('/socios', 'UserController@index')->name('users.index');
Route::middleware('auth')->get('/socios/create', 'UserController@create')->name('users.create');
Route::middleware('auth')->post('/socios', 'UserController@store')->name('users.store');
Route::middleware('auth')->get('/socios/{socio}/edit', 'UserController@edit')->name('users.edit');
Route::middleware('auth')->put('/socios/{socio}', 'UserController@update')->name('users.update');
Route::middleware('auth')->delete('/socios/{socio}', 'UserController@destroy')->name('users.destroy');
Route::middleware('auth')->patch('/socios/{socio}/quota', 'UserController@changeQuota')->name('quota.change');
Route::middleware('auth')->patch('/socios/reset_quotas', 'UserController@resetQuotas')->name('quotas.reset');
Route::middleware('auth')->patch('/socios/desativar_sem_quotas', 'UserController@desativarUsersSemQuotas')->name('users.desativar');
Route::middleware('auth')->patch('/socios/{socio}/ativo', 'UserController@changeAtivo')->name('ativo.change');
Route::middleware('auth')->get('/pilotos/{piloto}/certificado', 'UserController@certificadoPiloto')->name('ver.certificado');
Route::middleware('auth')->get('/pilotos/{piloto}/licenca', 'UserController@licencaPiloto')->name('ver.licenca');

//aeronaves 
Route::middleware('auth')->get('aeronaves', 'AeronaveController@index')->name('aeronaves.index');
Route::middleware('auth')->get('/aeronaves/create', 'AeronaveController@create')->name('aeronaves.create');
Route::middleware('auth')->post('/aeronaves', 'AeronaveController@store')->name('aeronaves.store');

Route::middleware('auth')->get('/aeronaves/{aeronave}/pilotos', 'AeronaveController@pilotosAutorizados')->name('aeronaves.pilotos');
Route::middleware('auth')->delete('/aeronaves/{aeronave}/pilotos/{piloto}', 'AeronaveController@naoAutorizarPiloto')->name('piloto.naoautorizar');

//movimentos
Route::middleware('auth')->get('/movimentos', 'MovimentoController@index')->name('movimentos.index');
Route::middleware('auth')->get('/movimentos/create', 'MovimentoController@create')->name('movimentos.create');
Route::middleware('auth')->post('/movimentos', 'MovimentoController@store')->name('movimentos.store');
Route::middleware('auth')->delete('/movimentos/{movimento}', 'MovimentoController@destroy')->name('movimentos.destroy');
Route::middleware('auth')->get('/movimentos/{movimento}/edit', 'MovimentoController@edit')->name('movimentos.edit');
Route::middleware('auth')->put('/movimentos/{movimento}', 'MovimentoController@update')->name('movimentos.update');