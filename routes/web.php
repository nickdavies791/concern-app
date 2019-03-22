<?php

Auth::routes(['register' => false, 'reset' => false]);

Route::group(['middleware' => ['auth']], function () {
    //Home Routes
    Route::get('/', function () { return redirect('home'); });
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
    //Route::post('group/staff/import', 'UserController@importGroups')->name('group.staff.import');
    //Route::get('group/staff/export', 'UserController@exportGroups')->name('group.staff.export');
    Route::get('groups', 'GroupController@index');

    // Concern Tag Routes
    Route::get('tag/import', 'TagImportController@index')->name('tag.import.index');
    Route::post('tag/import', 'TagImportController@store')->name('tag.import');
    Route::get('tag/export', 'TagExportController@index')->name('tag.export');
    Route::get('tags', 'TagSearchController@index');
    
    // Student related routes
    Route::post('students/import', 'StudentImportController@store')->name('student.import');
    Route::get('students/export', 'StudentExportController@index')->name('student.export');
    Route::get('students/sync', 'StudentController@update')->name('syncStudents');
    Route::resource('students', 'StudentController')->except(['update']);
    // Route::resource('siblings', 'SiblingController'); //Not used

    // Concern related routes
    Route::get('concerns/shared', 'ConcernController@shared')->name('concerns.shared'); //Method doesn't exist
    Route::resource('concerns', 'ConcernController');
    Route::delete('concerns/{concern}', 'ConcernController@delete')->name('concerns.delete');

    // Comment related routes
    Route::resource('comments', 'CommentController');
    Route::delete('comments/{comment}', 'CommentController@delete')->name('comments.delete');
    Route::get('users/me/concerns', 'UserConcernController@index')->name('user.concerns');

    // Storage related routes
    Route::get('documents/all', 'DocumentController@all');
    Route::resource('documents', 'DocumentController');
    Route::get('storage/{folderA}/{folderB}/{filename}', 'StorageController@addToSubFolder');
    Route::get('storage/{folder}/{filename}', 'StorageController@addToFolder')->name('storage');

    // Misc Routes
    Route::get('charts/total-concerns-by-tag', 'ChartController@totalConcernsByTag');
    Route::resource('charts', 'ChartController');
    Route::resource('reports', 'ReportController');
});
