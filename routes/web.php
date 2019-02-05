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

Auth::routes(['register' => false, 'reset' => false]);
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('settings','HomeController@settings')->name('settings');
Route::get('assembly/token/create', 'TokenController@create')->name('authorise-assembly');
Route::get('assembly/token/authorise', 'TokenController@store');
Route::get('staff/sync', 'UserController@update')->name('syncStaff');
Route::post('staff/import', 'UserController@import')->name('staff.import');
Route::get('students/sync', 'StudentController@update')->name('syncStudents');
Route::resource('students', 'StudentController')->except(['update']);
Route::resource('siblings', 'SiblingController');
Route::resource('groups', 'GroupController');
Route::get('documents/all', 'DocumentController@all');
Route::resource('documents', 'DocumentController');
Route::get('concerns/shared', 'ConcernController@shared')->name('concerns.shared');
Route::resource('concerns', 'ConcernController');
Route::delete('concerns/{concern}', 'ConcernController@delete')->name('concerns.delete');
Route::resource('comments', 'CommentController');
Route::delete('comments/{comment}', 'CommentController@delete')->name('comments.delete');
Route::get('users/me/concerns', 'UserController@concerns')->name('user.concerns');
Route::get('reports', 'ReportController@index')->name('reports.index');
Route::resource('tags', 'TagController');
Route::post('search', 'HomeController@search')->name('search');
Route::get('storage/{folderA}/{folderB}/{filename}', function ($folderA, $folderB, $file){
    return storage_folder_subfolder($folderA, $folderB, $file);
})->name('storage')->middleware('auth');

Route::get('storage/{folder}/{filename}', function ($folder, $file){
    return storage_folder($folder, $file);
})->name('storage')->middleware('auth');