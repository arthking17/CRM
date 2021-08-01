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
Route::get('/accounts', 'AccountController@index')->name('accounts');
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
Route::put('/users/photo/update', 'UserController@updatePhoto')->name('user.photo.update');
Route::put('/users/password/update', 'UserController@updatePassword')->name('password.update');
//route for delete user
Route::delete('/users/delete/{id}', 'UserController@destroy')->name('user.delete');
Route::delete('/users/restore/{id}', 'UserController@restore')->name('user.restore');
//route for retreive users
Route::get('/users', 'UserController@index')->name('users');
//route to get user in format json
Route::get('/users/get/{id}/{modal}', 'UserController@getUserJsonById')->name('user.get');
//route to get user permissions in format json
Route::get('/users/permissions/get/{id}/{modal}', 'Users_PermissionController@getUserPermissionsJsonById')->name('user.permissions.get');
//create note
//Route::post('/note/create', 'NoteController@store')->name('note.create');
//create permission
Route::post('/permission/create', 'Users_PermissionController@store')->name('users_permission.create');
//pagination user
Route::get('/users/pagination/fetch_data', 'UserController@fetch_data')->name('user.pagination');
//modal logs permissions notification note list by user
Route::get('/users/logs/get/{user_id}/{modal}', 'UserController@listLogs')->name('user.logs');
Route::get('/users/users_permissions/get/{user_id}', 'UserController@listUsers_Permissions')->name('user.users_permissions');
Route::get('/notes/get/{element_id}', 'NoteController@listNotes')->name('notes.get');
//delete users_permissions
Route::delete('/users_permission/delete/{user_id}/{code}', 'Users_PermissionController@destroy')->name('users_permission.delete');

// all activity logs 
Route::get('/users/logs', 'UserController@getAllLogs')->name('users.logs');

//route for module contact 
Route::get('/contacts', 'ContactController@index')->name('contacts');
Route::post('/contacts/create', 'ContactController@store')->name('contacts.create');
Route::get('/contacts/get/{id}/{modal}', 'ContactController@getContactJsonById')->name('contacts.get');
Route::put('/contacts/update', 'ContactController@update')->name('contacts.update');
Route::put('/contacts/logo/update', 'ContactController@updateContactCompanieLogo')->name('contacts.logo.update');
Route::delete('/contacts/delete/{id}', 'ContactController@destroy')->name('contacts.delete');

Route::view('contacts/upload', 'contacts/upload')->name('contacts.upload');
Route::post('contacts/upload', 'ContactController@upload')->name('contacts.upload');

Route::get('/contacts/search', 'ContactController@searchForm')->name('contacts.search');
Route::post('/contacts/search', 'ContactController@search')->name('contacts.search');
//route for groups of users
Route::get('/users/groups', 'GroupController@index')->name('users.groups');
Route::post('/users/groups/create', 'GroupController@store')->name('users.groups.create');
Route::put('/users/groups/update', 'GroupController@update')->name('users.groups.update');
Route::delete('/users/groups/delete/{id}', 'GroupController@destroy')->name('users.groups.delete');
Route::get('/users/groups/get/{id}/{modal}', 'GroupController@getGroupJsonById')->name('users.groups.get');
//route for contact data
Route::post('/contacts/data/create', 'Contact_dataController@store')->name('contacts.data.create');
Route::get('/contacts/data/get/{id}', 'Contact_dataController@getContactDataJsonById')->name('contacts.data.get');
Route::get('/contacts/data/edit/{id}', 'Contact_dataController@edit')->name('contacts.data.edit');
Route::put('/contacts/data/update', 'Contact_dataController@update')->name('contacts.data.update');
Route::delete('/contacts/data/delete/{id}', 'Contact_dataController@destroy')->name('contacts.data.delete');

//route for note module
Route::get('/notes', 'NoteController@index')->name('notes');
Route::post('/notes/create', 'NoteController@store')->name('notes.create');
Route::get('/notes/get/{id}/{modal}', 'NoteController@getNoteJsonById')->name('notes.get');
Route::put('/notes/update', 'NoteController@update')->name('notes.update');
Route::delete('/notes/delete/{id}', 'NoteController@destroy')->name('notes.delete');
Route::get('/notes/element/{element_id}/{element}', 'NoteController@show')->name('notes.element');