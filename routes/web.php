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
Auth::routes(['register' => false, 'verified' => true]);

Route::get('/password', 'UserController@changePassword')->name('password.change');
Route::patch('/password', 'UserController@savePassword')->name('password.save');
Route::post('/password/email', 'UserController@emailReset')->name('email');

Route::get('/socios', 'UserController@index')->name('users.index');
Route::get('/socios/create', 'UserController@create')->name('users.create');
Route::post('/socios/create', 'UserController@store')->name('users.store');
Route::get('/socios/{id}/edit', 'UserController@edit')->name('users.edit');
Route::put('/socios/{id}/edit', 'UserController@update')->name('users.update');
Route::delete('/socios/{id}', 'UserController@destroy')->name('users.destroy');

//26
Route::patch('/socios/{id}/quota', 'UserController@changeQuota')->name('quota.change');
Route::patch('/socios/reset_quotas', 'UserController@resetQuotas')->name('quotas.reset');

//27
Route::patch('/socios/{id}/ativo', 'UserController@changeAtivo')->name('ativo.change');
Route::patch('/socios/desativar_sem_quotas', 'UserController@desativarUsersSemQuotas')->name('users.desativar');

// Route::resource('socios', 'UserController')->show();
Route::get('aeronaves', 'AeronaveController@index')->name('aeronaves.index');