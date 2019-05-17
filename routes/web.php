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

Route::post('/password/email', 'UserController@emailReset')->name('email');


Auth::routes(['register' => false, 'verified' => true]);

Route::get('/profile', 'UserController@profile')->name('profile');

Route::get('/password', 'UserController@changePassword')->name('password.change');
Route::patch('/password', 'UserController@savePassword')->name('password.save');

Route::get('/socios', 'UserController@index')->name('users.index');
Route::get('/socios/create', 'UserController@create')->name('users.create');
Route::post('/socios/create', 'UserController@store')->name('users.store');
Route::get('/socios/{id}/edit', 'UserController@edit')->name('users.edit');
Route::put('/socios/{id}/edit', 'UserController@update')->name('users.update');
Route::delete('/socios/{id}', 'UserController@destroy')->name('users.destroy');

// Route::resource('socios', 'UserController')->show();