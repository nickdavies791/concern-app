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
    return view('auth.login');
});

Route::get('/blank', function () {
    return view('partials.blank');
});

Auth::routes([
    'register' => false,
    'reset' => false
]);

Route::view('settings','settings')->name('settings');
Route::get('assembly/token/create', 'TokenController@create')->name('authorise-assembly');
Route::get('assembly/token/authorise', 'TokenController@store');
Route::get('students/sync', 'StudentController@update')->name('syncStudents');
Route::get('staff/sync', 'UserController@update')->name('syncStaff');
Route::resource('students', 'StudentController')->except(['update']);


Route::get('/home', 'HomeController@index')->name('home');

Route::resource('concerns', 'ConcernController');
Route::resource('comments', 'CommentController');