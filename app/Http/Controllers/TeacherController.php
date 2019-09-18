<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherController extends Controller
{

    /**
     * 教师用户登录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $data = [];
        $data['user'] = $request->input('user');
        $data['passwd'] = $request->input('passwd');

        $token = '123124 wafa';
        $data['token'] = $token;

        return apiResponse('0', '登陆成功！', $data) ;

    }

    /**
     *
     */
    public function getinfo(Request $request)
    {
        $data = [];
        $data['name'] = $request->user;

        return apiResponse('0', '教师信息获取成功！', $data) ;

    }




}







?>
