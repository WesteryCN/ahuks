<?php
namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Http\Request;

    /**
     * 安徽大学数据库课程设计
     * 教师API模块
     * by: 刘方祥
     * i@2git.cn
     * i@westery.cn
     */

class TeacherController extends Controller
{

    /**
     * 教师用户登录
     */

    public function login(Request $request)
    {
        $data = [];
        try{
            $user = Teacher::getUser($request->input('user'),$request->input('passwd'));
            if ($user) {
                //$data['user'] = $user;
                return apiResponse('0', '教师登陆成功！', $user) ;
            }
            else {
                return apiResponse('301', '教师登陆失败！', $user) ;
            }

        }catch (\Exception $e) {
            return $e;
            //return $this->internalErrRes();
        }

    }

    /**
     * 用户登录，并置cookie，便于使用postman调试
     */

    public function logincookie(Request $request)
    {
        $response = $this->login($request);
        if($response->getData()->code == '0'){
            $data = $response->getData()->data;
            $response =$response ->cookie('token', $data->token, 3600);
            return $response;
        }else{
            return apiResponse('402', '教师登陆失败(cookie)！') ;
        }
    }

    /**
     * 用户登出，将token失效
     */

    public function logout(Request $request)
    {
        $data = [];
        $data['user'] = $request->user;
        $data['name'] = $request->name;
        $data['token'] = $request->token;
        try {
            $msg = Teacher::tokenInvalidate($request->token);

        }catch (\Exception $e) {
            return $e;
            //return $this->internalErrRes();
        }
        $data['msg'] = $msg;
        return apiResponse('0', '教师退出成功！', $data) ;

    }

    /**
     * 获取当前教师信息
     */

    public function getinfo(Request $request)
    {
        $data = [];
        $data['user'] = $request->user;
        $data['name'] = $request->name;

        return apiResponse('0', '教师信息获取成功！', $data) ;

    }

    /**
     * 重设当前用户密码
     */
    public function setPasswd(Request $request)
    {
        $data = [];
        if(strlen( $request->input('passwd')) < 6 ){
            return apiResponse('401', '密码过短，请设置长于6字符的密码！', $data) ;
        }
        $data['user']=$request->user;
        try{
            $re_msg = Teacher::setPasswd($request->user,$request->input('passwd'));
            $data['re_msg']=$re_msg;
            return apiResponse('0', '教师密码修改成功！', $data) ;

        }catch (\Exception $e) {
            return $e;
            //return $this->internalErrRes();
        }


    }

    /**
     * 获取学生列表
     */
    public function liststd(){
        $data = [];
        $data2 = [];
        try{
        $data2 = Student::liststd();
        if ($data2['code']=='1'){
            if(sizeof($data2) >1)
            $data = $data2['std'];
            return apiResponse('0', '获取学生信息成功！', $data) ;
        }
        }catch (\Exception $e) {
            return $e;
            //return $this->internalErrRes();
        }

    }

    /**
     * 增加学生
     */

    public function addstd(Request $request){
        $data = [];
        if(!$request->input('std_user') or !$request->input('std_name') or !$request->input('std_passwd')){
            return apiResponse('402', '用户名、姓名、密码不能为空。') ;
        }
        try{
            $data['std_user'] = $request->input('std_user');
            $data['std_name'] = $request->input('std_name');
            $data['std_passwd'] = $request->input('std_passwd');
            $data['std_class_id'] = $request->input('std_class_id');
            $data['std_sex'] = $request->input('std_sex');
            $data['std_grade'] = $request->input('std_grade');
            $data['std_academy'] = $request->input('std_academy');
            $data['std_email'] = $request->input('std_email');




            $code = Student::addone($data);
            if($code == 1){
                return apiResponse('401', '用户已存在。') ;
            }else{
                return apiResponse('0', '学生账号创建成功！',$data) ;
            }

        }catch (\Exception $e) {
            return $e;
            //return $this->internalErrRes();
        }



    }

    /**
     * 删除学生
     */
    public function delstd(Request $request){
        $data = [];
        if(!$request->input('std_user')){
            return apiResponse('402', '学生学号不能为空。') ;
        }
        try{
            $code = Student::delone(  $request->input('std_user'));
            if($code == 1){
                return apiResponse('401', '学生不存在。') ;
            }else{
                $data['std_user'] = $request->input('std_user');
                return apiResponse('0', '学生删除成功！',$data) ;
            }

        }catch (\Exception $e) {
            return $e;
            //return $this->internalErrRes();
        }



    }

    /**
     * 重设学生个人信息
     */

    public function setstdinfo(Request $request)
    {
        $data = [];
        if(!$request->input('std_user') or !$request->input('std_name')){
            return apiResponse('402', '用户名、姓名不能为空。') ;
        }
        //$data['user']=$request->user;
        try{
            $data['std_user'] = $request->input('std_user');
            $data['std_name'] = $request->input('std_name');
            $data['std_class_id'] = $request->input('std_class_id');
            $data['std_sex'] = $request->input('std_sex');
            $data['std_grade'] = $request->input('std_grade');
            $data['std_academy'] = $request->input('std_academy');
            $data['std_email'] = $request->input('std_email');

            $code = Student::setinfo($data);
            if($code['code'] == 1){
                return apiResponse('0', '学生信息修改成功！',$code) ;

            }else{
                return apiResponse('401', '用户不存在。') ;
            }



        }catch (\Exception $e) {
            return $e;
            //return $this->internalErrRes();
        }


    }




}







?>
