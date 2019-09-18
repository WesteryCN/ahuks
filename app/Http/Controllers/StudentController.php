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
        //$data['user'] = $request->input('user');
        //$data['passwd'] = $request->input('passwd');

        $token = '00000';
        $data['token'] = $token;

        try{
            $user = Student::getUser($request->input('user'),$request->input('passwd'));
            if ($user) {
                $data['user'] = $user;
                $token = substr(md5(uniqid()), 0, 16);
                $data['token'] = $token;
                return apiResponse('0', '学生登陆成功！', $data) ;
            }
            else {
                return apiResponse('0', '学生登陆失败！', $data) ;
            }
        }catch (\Exception $e) {
            return $this->internalErrRes();
        }



    }

    /**
     *
     */
    public function getinfo(Request $request)
    {
        $data = [];
        $data['name'] = $request->user;

        return apiResponse('0', '学生信息获取成功！', $data) ;

    }




}







?>
