<?php

use Illuminate\Support\Facades\Route;

Route::resource('students', 'StudentController');
Route::resource('courses', 'CourseController');
Route::get('studentRegistrations/statistics', 'StudentRegistrationController@statistics');
Route::resource('studentRegistrations', 'StudentRegistrationController');
