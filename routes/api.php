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

/** 安徽大学数据库课程设计
  * 路由部分
  * by: 刘方祥
  * i@2git.cn
  * i@westery.cn
  */


Route::post('teacher/login','TeacherController@login');
Route::post('teacher/loginc','TeacherController@logincookie');

Route::post('student/login','StudentController@login');
Route::post('student/loginc','StudentController@logincookie');

//教师管理模块
Route::middleware(['token.checkAndRenew.teacher'])->prefix('teacher')->group(function () {
    Route::get('info', 'TeacherController@getinfo'); //调取信息
    Route::get('logout', 'TeacherController@logout'); //登出
    Route::post('setpasswd', 'TeacherController@setpasswd'); //置密码
    Route::get('liststd', 'TeacherController@liststd'); //列出所有学生
    Route::post('addstd', 'TeacherController@addstd'); //增加学生
    Route::post('delstd', 'TeacherController@delstd'); //删除学生

});

//学生管理模块
Route::middleware(['token.checkAndRenew.student'])->prefix('student')->group(function () {
    Route::get('info', 'StudentController@getinfo');
    Route::get('logout', 'StudentController@logout');
    Route::post('setpasswd', 'StudentController@setpasswd');



});

