<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{

    /**
     * 学生用户登录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function login(Request $request)
    {
        $data = [];
        try{
            $user = Student::getUser($request->input('user'),$request->input('passwd'));
            if ($user) {
                //$data['user'] = $user;
                return apiResponse('0', '学生登陆成功！', $user) ;
            }
            else {
                return apiResponse('301', '学生登陆失败！', $user) ;
            }
        }catch (\Exception $e) {
            return $e;
            //return $this->internalErrRes();
        }

    }
    public function logincookie(Request $request)
    {
        $response = $this->login($request);
        if($response->getData()->code == '0'){
            $data = $response->getData()->data;
            $response =$response ->cookie('token', $data->token, 3600);
            return $response;
        }else{
            return apiResponse('302', '学生登陆失败(cookie)！') ;
        }
    }



    public function getinfo(Request $request)
    {
        $data = [];
        $data['user'] = $request->user;
        $data['name'] = $request->name;

        return apiResponse('0', '学生信息获取成功！', $data) ;

    }

    public function logout(Request $request)
    {
        $data = [];
        $data['user'] = $request->user;
        $data['name'] = $request->name;
        $data['token'] = $request->token;
        try {
            $msg = Student::tokenInvalidate($request->token);

        }catch (\Exception $e) {
            return $e;
            //return $this->internalErrRes();
        }
        $data['msg'] = $msg;
        return apiResponse('0', '退出成功！', $data) ;

    }



}







?>
