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
    Route::post('info', 'TeacherController@getTeacherInfo'); //调取教师信息
    Route::get('info', 'TeacherController@getTeacherInfo'); //调取教师信息
    Route::get('logout', 'TeacherController@logout'); //登出
    Route::post('setpasswd', 'TeacherController@setpasswd'); //置密码
    Route::get('liststd', 'TeacherController@liststd'); //列出所有学生
    Route::post('liststd', 'TeacherController@liststd'); //列出所有学生
    Route::post('addstd', 'TeacherController@addstd'); //增加学生
    Route::post('delstd', 'TeacherController@delstd'); //删除学生
    Route::post('setstdinfo', 'TeacherController@setstdinfo'); //修改学生信息

    Route::post('getclass', 'ClassController@getinfo'); //列出班级
    Route::get('getclass', 'ClassController@getinfo'); //列出班级
    Route::post('addclass', 'ClassController@addclass'); //添加班级
    Route::post('delclass', 'ClassController@delclass'); //删除班级

    Route::post('addexam', 'ExamController@addexam'); //添加考试
    Route::get('listexam', 'ExamController@listexam'); //列出考试
    Route::post('listexam', 'ExamController@listexam'); //列出考试
    Route::post('delexam', 'ExamController@delexam'); //删除考试

    Route::post('linkexam', 'ExamController@linkexam'); //关联考试
    Route::get('listlink', 'ExamController@listlink'); //列出关联
    Route::post('listlink', 'ExamController@listlink'); //列出关联
    Route::post('dellink', 'ExamController@dellink'); //删除考试
    Route::post('dellink2', 'ExamController@dellink2'); //删除考试2

    Route::post('addques', 'QuestionController@addquestion'); //添加考题
    Route::post('delques', 'QuestionController@delquestion'); //删除考题
    Route::post('leftscore', 'QuestionController@leftscore'); //考试剩余分数
    Route::post('listques', 'QuestionController@listquestion'); //列出考题




    Route::post('sendemail', 'SendEmailController@send'); //发送邮件


});

//学生管理模块
Route::middleware(['token.checkAndRenew.student'])->prefix('student')->group(function () {
    Route::get('info', 'StudentController@getinfo'); //获取信息
    Route::get('logout', 'StudentController@logout'); //登出
    Route::post('setpasswd', 'StudentController@setpasswd'); //修改密码


    Route::get('getexam', 'StudentExamController@getmyexam'); //获取我的考试

    Route::post('startask', 'StudentExamController@startask'); //开始答题考题
    Route::post('getquestion', 'StudentExamController@getmyexamquestion'); //获取考试考题
    Route::post('endask', 'StudentExamController@endask'); //结束答题并提交答案

    Route::post('getmyscore', 'AnalysisController@getmyscore'); //取我的成绩


});

