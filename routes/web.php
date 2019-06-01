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

Route::middleware(['auth', 'verified', 'userAtivo'])->group(function () {
	//password
	Route::get('/password', 'UserController@changePassword')->name('password.change');
	Route::patch('/password', 'UserController@savePassword')->name('password.save');

	//socios
	Route::get('/socios', 'UserController@index')->name('users.index');
	Route::get('/socios/create', 'UserController@create')->name('users.create');
	Route::post('/socios', 'UserController@store')->name('users.store');
	Route::get('/socios/{socio}/edit', 'UserController@edit')->name('users.edit');
	Route::put('/socios/{socio}', 'UserController@update')->name('users.update');
	Route::delete('/socios/{socio}', 'UserController@destroy')->name('users.destroy');
	Route::patch('/socios/{socio}/quota', 'UserController@changeQuota')->name('quota.change');
	Route::patch('/socios/reset_quotas', 'UserController@resetQuotas')->name('quotas.reset');
	Route::patch('/socios/desativar_sem_quotas', 'UserController@desativarUsersSemQuotas')->name('users.desativar');
	Route::patch('/socios/{socio}/ativo', 'UserController@changeAtivo')->name('ativo.change');
	Route::get('/pilotos/{piloto}/certificado', 'UserController@certificadoPiloto')->name('certificado.piloto');
	Route::get('/pilotos/{piloto}/licenca', 'UserController@licencaPiloto')->name('licenca.piloto');
	Route::post('/socios/{socio}/send_reactivate_mail', 'UserController@reenviarEmailAtivacao')->name('reenviar.email');


	//aeronaves
	Route::get('aeronaves', 'AeronaveController@index')->name('aeronaves.index');
	Route::get('/aeronaves/create', 'AeronaveController@create')->name('aeronaves.create');
	Route::post('/aeronaves', 'AeronaveController@store')->name('aeronaves.store');
	Route::get('/aeronaves/{aeronave}/edit', 'AeronaveController@edit')->name('aeronaves.edit');
	Route::put('/aeronaves/{aeronave}', 'AeronaveController@update')->name('aeronaves.update');
	Route::get('/aeronaves/{aeronave}/pilotos', 'AeronaveController@pilotosAutorizados')->name('aeronaves.pilotos');
	Route::delete('/aeronaves/{aeronave}/pilotos/{piloto}', 'AeronaveController@naoAutorizarPiloto')->name('piloto.naoautorizar');
	Route::post('/aeronaves/{aeronave}/pilotos/{piloto}', 'AeronaveController@autorizarPiloto')->name('piloto.autorizar');
	Route::delete('/aeronaves/{aeronave}', 'AeronaveController@destroy')->name('aeronaves.destroy');

	//movimentos
	Route::get('/movimentos', 'MovimentoController@index')->name('movimentos.index');
	Route::get('/movimentos/create', 'MovimentoController@create')->name('movimentos.create');
	Route::post('/movimentos', 'MovimentoController@store')->name('movimentos.store');
	Route::delete('/movimentos/{movimento}', 'MovimentoController@destroy')->name('movimentos.destroy');
	Route::get('/movimentos/{movimento}/edit', 'MovimentoController@edit')->name('movimentos.edit');
	Route::put('/movimentos/{movimento}', 'MovimentoController@update')->name('movimentos.update');

	//estatisticas
	Route::get('/movimentos/estatisticas', 'MovimentoController@estatisticas')->name('movimentos.estatisticas');

	//pendentes
	Route::get('/pendentes', 'UserController@assuntosPendentes')->name('acesso.pendentes');
});
