<?php

use App\Mail\SendMail;
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
})->name('home')->middleware('auth');

//route for create account
Route::view('/accounts/create', 'accounts/create')->name('account.create')->middleware('auth');
Route::post('/accounts/create', 'AccountController@store')->name('account.create')->middleware('auth');
//route for retreive account
Route::get('/accounts', 'AccountController@index')->name('accounts')->middleware('auth');
Route::get('/accounts/{id}', 'AccountController@getAccountById')->name('account.get')->middleware('auth');
//route for update account
Route::put('/accounts/update', 'AccountController@update')->name('account.update')->middleware('auth');
Route::delete('/accounts/{id}', 'AccountController@destroy')->name('account.delete')->middleware('auth');

//route for create user
Route::get('/users/create', 'UserController@create')->name('user.create');
Route::post('/users/create', 'UserController@store')->name('user.create');
//route for update user
Route::get('/users/edit/{id}', 'UserController@getUserById')->name('user.edit')->middleware('auth');
Route::put('/users/update/{page_name}', 'UserController@update')->name('user.update')->middleware('auth');
Route::put('/users/photo/update', 'UserController@updatePhoto')->name('user.photo.update')->middleware('auth');
Route::put('/users/password/update', 'UserController@updatePassword')->name('password.update')->middleware('auth');
//route for delete user
Route::delete('/users/delete/{id}', 'UserController@destroy')->name('user.delete')->middleware('auth');
Route::delete('/users/restore/{id}', 'UserController@restore')->name('user.restore')->middleware('auth');
//route for retreive users
Route::get('/users', 'UserController@index')->name('users')->middleware('auth');
//route for retreive user
Route::get('/users/view/{id}', 'UserController@view')->name('users.view')->middleware('auth');
//route to get user in format json
Route::get('/users/get/{id}/{modal}', 'UserController@getUserJsonById')->name('user.get')->middleware('auth');
//route to get user permissions in format json
Route::get('/users/permissions/get/{user_id}/{modal}', 'Users_PermissionController@getUserPermissionsJsonByUserId')->name('user.permissions.get')->middleware('auth');
//create note
//Route::post('/note/create', 'NoteController@store')->name('note.create')->middleware('auth');
//create permission
Route::post('/permission/create', 'Users_PermissionController@store')->name('users_permission.create')->middleware('auth');
//pagination user
Route::get('/users/grid-view', 'UserController@getGridView')->name('user.pagination')->middleware('auth');
//modal logs permissions notification list by user
Route::get('/users/logs/get/{user_id}/{modal}', 'UserController@listLogs')->name('user.logs')->middleware('auth');
Route::get('/users/users_permissions/get/{user_id}', 'UserController@listUsers_Permissions')->name('user.users_permissions')->middleware('auth');
//delete users_permissions
Route::delete('/users_permission/delete/{user_id}/{code}', 'Users_PermissionController@destroy')->name('users_permission.delete')->middleware('auth');

// all activity logs 
Route::get('/users/logs', 'UserController@getAllLogs')->name('users.logs')->middleware('auth');

//route for module contact 
Route::get('/contacts', 'ContactController@index')->name('contacts')->middleware('auth');
Route::get('/contacts/view/{id}', 'ContactController@view')->name('contacts.view')->middleware('auth');
Route::post('/contacts/create', 'ContactController@store')->name('contacts.create')->middleware('auth');
Route::get('/contacts/get/{id}/{modal}', 'ContactController@getContactJsonById')->name('contacts.get')->middleware('auth');
Route::put('/contacts/update/{page_name}', 'ContactController@update')->name('contacts.update')->middleware('auth');
Route::put('/contacts/logo/update', 'ContactController@updateContactCompanieLogo')->name('contacts.logo.update')->middleware('auth');
Route::delete('/contacts/delete/{id}', 'ContactController@destroy')->name('contacts.delete')->middleware('auth');
Route::get('/contacts/id/{id}', 'ContactController@findContactId')->name('contacts.id')->middleware('auth');
Route::get('/contacts/source_id/{source_id}', 'ContactController@getContactsSourceId')->name('contacts.source_id')->middleware('auth');

Route::get('contacts/upload', 'ContactController@uploadForm')->name('contacts.import')->middleware('auth');
Route::post('contacts/upload/preview', 'ContactController@previewContactsImport')->name('contacts.upload.preview')->middleware('auth');
Route::post('contacts/upload/{skipErrors}', 'ContactController@upload')->name('contacts.upload')->middleware('auth');

Route::get('/contacts/search', 'ContactController@searchForm')->name('contacts.search')->middleware('auth');
Route::post('/contacts/search', 'ContactController@search')->name('contacts.search')->middleware('auth');
//route for groups of contacts
Route::get('/contacts/groups', 'GroupController@index')->name('contacts.groups')->middleware('auth');
Route::post('/contacts/groups/create', 'GroupController@store')->name('contacts.groups.create')->middleware('auth');
Route::put('/contacts/groups/update', 'GroupController@update')->name('contacts.groups.update')->middleware('auth');
Route::delete('/contacts/groups/delete/{id}', 'GroupController@destroy')->name('contacts.groups.delete')->middleware('auth');
Route::get('/contacts/groups/get/{id}/{modal}', 'GroupController@getGroupJsonById')->name('contacts.groups.get')->middleware('auth');
//route for contact data
Route::post('/contacts/data/create', 'Contact_dataController@store')->name('contacts.data.create')->middleware('auth');
Route::get('/contacts/data/get/{element_id}/{element}', 'Contact_dataController@getContactDataJsonByElementId')->name('contacts.data.get')->middleware('auth');
Route::get('/contacts/data/edit/{id}', 'Contact_dataController@edit')->name('contacts.data.edit')->middleware('auth');
Route::put('/contacts/data/update', 'Contact_dataController@update')->name('contacts.data.update')->middleware('auth');
Route::delete('/contacts/data/delete/{id}', 'Contact_dataController@destroy')->name('contacts.data.delete')->middleware('auth');
Route::get('/contacts/data/get/{element_id}/{element}/{class}', 'Contact_dataController@getContactDataByElement')->name('contacts.data.element.get')->middleware('auth');

//route for note module
Route::get('/notes', 'NoteController@index')->name('notes')->middleware('auth');
Route::post('/notes/create', 'NoteController@store')->name('notes.create')->middleware('auth');
Route::get('/notes/get/{id}/{modal}', 'NoteController@getNoteJsonById')->name('notes.get')->middleware('auth');
Route::put('/notes/update', 'NoteController@update')->name('notes.update')->middleware('auth');
Route::delete('/notes/delete/{id}', 'NoteController@destroy')->name('notes.delete')->middleware('auth');
Route::get('/notes/element/{element_id}/{element}', 'NoteController@show')->name('notes.element')->middleware('auth');
Route::get('/notes/element/modal/{element_id}/{element}', 'NoteController@showInModal')->name('notes.element.modal')->middleware('auth');

//route for custom fields
Route::get('/contacts/custom-fields', 'CustomFieldController@index')->name('custom-fields')->middleware('auth');
Route::get('/contacts/custom-fields/get/{id}', 'CustomFieldController@edit')->name('custom-fields.get')->middleware('auth');
Route::post('/contacts/custom-fields/create', 'CustomFieldController@store')->name('custom-fields.create')->middleware('auth');
Route::put('/contacts/custom-fields/update', 'CustomFieldController@update')->name('custom-fields.update')->middleware('auth');
Route::delete('/contacts/custom-fields/delete/{id}', 'CustomFieldController@destroy')->name('custom-fields.delete')->middleware('auth');
Route::get('/contacts/custom-fields/form/{contact_id}/{form_type}', 'CustomFieldController@formCustomFields')->name('custom-fields.form')->middleware('auth');

//route for contacts fields 
Route::delete('/contacts/field/file/{id}', 'CustomFieldController@deleteContactFieldFile')->name('contacts_field_file.delete')->middleware('auth');

//route for login
Route::get('login', 'LoginController@index')->name('login');
Route::post('authenticate', 'LoginController@authenticate')->name('login.authenticate');
Route::get('signout', 'LoginController@signOut')->name('signout');

//route for appointments
Route::get('/appointments', 'AppointmentController@index')->name('appointments')->middleware('auth');
Route::get('/appointments/all', 'AppointmentController@getAllAppointments')->name('appointments.all')->middleware('auth');
Route::get('/appointments/get/{id}', 'AppointmentController@getAppointment')->name('appointments.get')->middleware('auth');
Route::post('/appointments/create/{type}', 'AppointmentController@store')->name('appointments.create')->middleware('auth');
Route::put('/appointments/update', 'AppointmentController@update')->name('appointments.update')->middleware('auth');
Route::delete('/appointments/delete/{id}', 'AppointmentController@destroy')->name('appointments.delete')->middleware('auth');

//route for communications
Route::get('/communications', 'CommunicationController@index')->name('communications')->middleware('auth');
Route::get('/communications/get/{id}', 'CommunicationController@getCommunication')->name('communications.get')->middleware('auth');
Route::get('/communications/show/{id}', 'CommunicationController@show')->name('communications.show')->middleware('auth');
Route::post('/communications/create/{page_name}', 'CommunicationController@store')->name('communications.create')->middleware('auth');
Route::put('/communications/update', 'CommunicationController@update')->name('communications.update')->middleware('auth');
Route::delete('/communications/delete/{id}', 'CommunicationController@destroy')->name('communications.delete')->middleware('auth');

//route for profile user
Route::get('/profile', 'ProfileController@index')->name('profile')->middleware('auth');
Route::put('/profile/update', 'ProfileController@update')->name('profile.update')->middleware('auth');
Route::get('/settings', 'ProfileController@settings')->name('settings')->middleware('auth');

//route for email account
Route::post('/email_accounts/create', 'EmailAccountController@store')->name('email_accounts.create')->middleware('auth');
Route::put('/email_accounts/update', 'EmailAccountController@update')->name('email_accounts.update')->middleware('auth');
Route::get('/email_accounts/get/{id}', 'EmailAccountController@getEmailAccount')->name('email_accounts.get')->middleware('auth');
Route::delete('/email_accounts/delete/{id}', 'EmailAccountController@destroy')->name('email_accounts.delete')->middleware('auth');
Route::get('/email_accounts/get', 'EmailAccountController@getAllEmailAccount')->name('email_accounts')->middleware('auth');
Route::post('/send_mail', 'EmailAccountController@sendMail')->name('send_mail')->middleware('auth');
Route::get('/mail', 'EmailAccountController@showMailTemplate')->name('mail.template')->middleware('auth');
Route::get('/email_accounts/config/{id}', 'EmailAccountController@configEmailAccount')->name('email_accounts.config')->middleware('auth');
Route::get('/mailbox', 'EmailAccountController@showMailBox')->name('mail.box')->middleware('auth');

//route for sip_accounts
Route::get('/sip_accounts', 'SipAccountController@index')->name('sip_accounts')->middleware('auth');
Route::get('/sip_accounts/all', 'SipAccountController@getAllSipAccount')->name('sip_accounts.all')->middleware('auth');
Route::get('/sip_accounts/get/{id}', 'SipAccountController@getSipAccount')->name('sip_accounts.get')->middleware('auth');
Route::post('/sip_accounts/create', 'SipAccountController@store')->name('sip_accounts.create')->middleware('auth');
Route::put('/sip_accounts/update', 'SipAccountController@update')->name('sip_accounts.update')->middleware('auth');
Route::delete('/sip_accounts/delete/{id}', 'SipAccountController@destroy')->name('sip_accounts.delete')->middleware('auth');
Route::get('/sip_accounts/show/{id}', 'SipAccountController@show')->name('sip_accounts.show')->middleware('auth');
Route::get('/sip_accounts/calls/logs', 'SipAccountController@getAllCallsLogs')->name('sip_accounts.calls.logs')->middleware('auth');

//route for sms account
Route::post('/sms_accounts/create', 'SMSAccountController@store')->name('sms_accounts.create')->middleware('auth');
Route::put('/sms_accounts/update', 'SMSAccountController@update')->name('sms_accounts.update')->middleware('auth');
Route::get('/sms_accounts/get/{id}', 'SMSAccountController@getSMSAccount')->name('sms_accounts.get')->middleware('auth');
Route::delete('/sms_accounts/delete/{id}', 'SMSAccountController@destroy')->name('sms_accounts.delete')->middleware('auth');
Route::get('/sms_accounts/get', 'SMSAccountController@getAllSMSAccount')->name('sms_accounts')->middleware('auth');
Route::get('/sms', 'SMSAccountController@chat')->name('chat')->middleware('auth');
Route::post('/sms/send', 'SMSAccountController@sendSMS')->name('sms.send')->middleware('auth');

//route for shortcodes settings
Route::post('/shortcodes/create', 'ShortCodeController@store')->name('shortcodes.create')->middleware('auth');
Route::put('/shortcodes/update', 'ShortCodeController@update')->name('shortcodes.update')->middleware('auth');
Route::get('/shortcodes/get/{id}', 'ShortCodeController@get')->name('shortcodes.get')->middleware('auth');
Route::delete('/shortcodes/delete/{id}', 'ShortCodeController@destroy')->name('shortcodes.delete')->middleware('auth');
Route::get('/shortcodes/get', 'ShortCodeController@getAllShortCodes')->name('shortcodes')->middleware('auth');

//route for users_sip_accounts settings
Route::post('/users_sip_accounts/create', 'Users_SipAccountsController@store')->name('users_sip_accounts.create')->middleware('auth');
Route::put('/users_sip_accounts/update', 'Users_SipAccountsController@update')->name('users_sip_accounts.update')->middleware('auth');
Route::get('/users_sip_accounts/get/{id}', 'Users_SipAccountsController@get')->name('users_sip_accounts.get')->middleware('auth');
Route::delete('/users_sip_accounts/delete/{id}', 'Users_SipAccountsController@destroy')->name('users_sip_accounts.delete')->middleware('auth');
Route::get('/users_sip_accounts/get', 'Users_SipAccountsController@getAllUserSipAccounts')->name('users_sip_accounts')->middleware('auth');