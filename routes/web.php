<?php

Auth::routes(['register' => false, 'reset' => false]);

Route::group(['middleware' => ['auth']], function () {
    //Home Routes
    Route::view('/', 'welcome');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::view('settings','settings')->name('settings');
    Route::post('search', 'HomeController@search')->name('search');
    
    // Assembly API Routes
    Route::get('assembly/token/create', 'TokenController@create')->name('authorise-assembly');
    Route::get('assembly/token/authorise', 'TokenController@store');

    Route::get('school/sync', 'SchoolController@update')->name('syncSchool');
    
    // Staff (main users) related routes
    Route::get('staff/sync', 'UserController@update')->name('syncStaff');
    Route::post('staff/import', 'StaffImportController@store')->name('staff.import');
    Route::get('staff/export', 'StaffExportController@index')->name('staff.export');

    // Staff Group Routes
    Route::post('group/import', 'GroupImportController@store')->name('group.import');
    Route::get('group/export', 'GroupExportController@index')->name('group.export');

    // Should create this in app, rather than importing
    // Route::post('group/staff/import', 'UserController@importGroups')->name('group.staff.import');
    
    Route::get('group/staff/export', 'UserController@exportGroups')->name('group.staff.export');
    Route::resource('groups', 'GroupController');

    // Student related routes
    Route::post('student/import', 'StudentController@import')->name('student.import');
    Route::get('student/export', 'StudentController@export')->name('student.export');
    Route::get('students/sync', 'StudentController@update')->name('syncStudents');
    Route::resource('students', 'StudentController')->except(['update']);
    Route::resource('siblings', 'SiblingController');
    
    // Concern Tag Routes
    Route::post('tag/import', 'TagController@import')->name('tag.import');
    Route::get('tag/export', 'TagController@export')->name('tag.export');
    Route::resource('tags', 'TagController');

    // Concern related routes
    Route::get('concerns/shared', 'ConcernController@shared')->name('concerns.shared');
    Route::resource('concerns', 'ConcernController');
    Route::delete('concerns/{concern}', 'ConcernController@delete')->name('concerns.delete');
    Route::resource('comments', 'CommentController');
    Route::delete('comments/{comment}', 'CommentController@delete')->name('comments.delete');
    Route::get('users/me/concerns', 'UserConcernController@index')->name('user.concerns');

    // Storage related routes
    Route::get('documents/all', 'DocumentController@all');
    Route::resource('documents', 'DocumentController');
    Route::get('storage/{folderA}/{folderB}/{filename}', 'StorageController@addToSubFolder');
    Route::get('storage/{folder}/{filename}', 'StorageController@addToFolder');

    // Misc Routes
    Route::get('charts/total-concerns-by-tag', 'ChartController@totalConcernsByTag');
    Route::resource('charts', 'ChartController');
    Route::resource('reports', 'ReportController');
});
