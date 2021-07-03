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

Route::view('/accounts/create', 'accounts/create')->name('create-account');
Route::post('/accounts/create', 'AccountsController@store')->name('create-account');
Route::get('/accounts', 'AccountsController@getAllAccounts')->name('accounts');
Route::get('/accounts/{id}', 'AccountsController@getAccountById')->name('get-account');
Route::put('/accounts/update', 'AccountsController@update')->name('update-account');
Route::delete('/accounts/{id}', 'AccountsController@destroy')->name('delete-account');