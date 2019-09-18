<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('teacher/login','TeacherController@login');
Route::post('student/login','StudentController@login');
Route::post('student/loginc','StudentController@logincookie');

//教师管理模块
Route::middleware(['token.checkAndRenew.teacher'])->prefix('teacher')->group(function () {
    Route::get('info', 'TeacherController@getinfo');


});

Route::middleware(['token.checkAndRenew.student'])->prefix('student')->group(function () {
    Route::get('info', 'StudentController@getinfo');
    Route::get('logout', 'StudentController@logout');



});

