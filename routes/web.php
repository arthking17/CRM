<?php

use Illuminate\Support\Facades\DB;
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
    return view('home');
})->name('home');

//route for create account
Route::view('/accounts/create', 'accounts/create')->name('account.create');
Route::post('/accounts/create', 'AccountController@store')->name('account.create');
//route for retreive account
Route::get('/accounts', 'AccountController@getAllAccounts')->name('accounts');
Route::get('/accounts/{id}', 'AccountController@getAccountById')->name('account.get');
//route for update account
Route::put('/accounts/update', 'AccountController@update')->name('account.update');
Route::delete('/accounts/{id}', 'AccountController@destroy')->name('account.delete');

//route for create user
Route::get('/users/create', 'UserController@create')->name('user.create');
Route::post('/users/create', 'UserController@store')->name('user.create');
//route for update user
Route::get('/users/edit/{id}', 'UserController@getUserById')->name('user.edit');
Route::put('/users/update/{id}', 'UserController@update')->name('user.update');
//route for delete user
Route::delete('/users/delete/{id}', 'UserController@destroy')->name('user.delete');
Route::delete('/users/restore/{id}', 'UserController@restore')->name('user.restore');
//route for retreive users
Route::get('/users', 'UserController@getAllUsers')->name('users');
//route to get user in format json
Route::get('/users/get/{id}', 'UserController@getUserJsonById')->name('user.get');
//create note
Route::post('/note/create', 'NoteController@store')->name('note.create');
//pagination user
Route::get('/users/pagination/fetch_data', 'UserController@fetch_data')->name('user.pagination');