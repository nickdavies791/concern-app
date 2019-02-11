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

// Create the Transport
$transport = (new Swift_SmtpTransport('clpt-co-uk.mail.protection.outlook.com', 25))
  ->setUsername('techsupport@clpt.co.uk')
  ->setPassword('147Polki');

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

// Create a message
$message = (new Swift_Message('Wonderful Subject'))
  ->setFrom(['john@doe.com' => 'John Doe'])
  ->setTo('nick.davies@clpt.co.uk')
  ->setBody('Here is the message itself');

// Send the message
$result = $mailer->send($message);





Auth::routes(['register' => false, 'reset' => false]);
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('settings','HomeController@settings')->name('settings');
Route::get('assembly/token/create', 'TokenController@create')->name('authorise-assembly');
Route::get('assembly/token/authorise', 'TokenController@store');
Route::get('staff/sync', 'UserController@update')->name('syncStaff');

Route::post('staff/import', 'UserController@import')->name('staff.import');
Route::get('staff/export', 'UserController@export')->name('staff.export');
Route::post('student/import', 'StudentController@import')->name('student.import');
Route::get('student/export', 'StudentController@export')->name('student.export');
Route::post('tag/import', 'TagController@import')->name('tag.import');
Route::get('tag/export', 'TagController@export')->name('tag.export');
Route::post('group/import', 'GroupController@import')->name('group.import');
Route::get('group/export', 'GroupController@export')->name('group.export');
Route::post('group/staff/import', 'UserController@importGroups')->name('group.staff.import');
Route::get('group/staff/export', 'UserController@exportGroups')->name('group.staff.export');

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

Route::resource('charts', 'ChartController');
Route::resource('reports', 'ReportController');

Route::get('charts/total-concerns-by-tag', 'ChartController@totalConcernsByTag');

Route::resource('tags', 'TagController');
Route::post('search', 'HomeController@search')->name('search');

Route::get('storage/{folderA}/{folderB}/{filename}', function ($folderA, $folderB, $file){
    return storage_folder_subfolder($folderA, $folderB, $file);
})->name('storage')->middleware('auth');

Route::get('storage/{folder}/{filename}', function ($folder, $file){
    return storage_folder($folder, $file);
})->name('storage')->middleware('auth');