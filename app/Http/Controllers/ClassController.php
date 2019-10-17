<?php
namespace App\Http\Controllers;

use App\Models\Classid;
use App\Models\Teacher;
use Illuminate\Http\Request;

/**
 * 安徽大学数据库课程设计
 *  班级管理模块
 * by: 刘方祥
 * i@2git.cn
 * i@westery.cn
 */
class ClassController extends Controller
{
    /**
     * @param Request $request
     * @return \Exception|\Illuminate\Http\JsonResponse
     * 获取班级信息
     */

    public static function getinfo(Request $request){
        $data = [];
        try{
            $class_id = $request ->input('c_id');
            if($class_id == null){
                $class_id = -1;
            }
            $data = Classid::listclass($class_id);
            if($data['code'] == '1'){
                return apiResponse('0', '班级信息获取成功！', $data) ;
            }else{
                return apiResponse('401', '班级不存在！', $data) ;
            }
        }catch (\Exception $e) {
            return $e;
            //return $this->internalErrRes();
        }


    }

    /**
     * @param Request $request
     * @return \Exception|\Illuminate\Http\JsonResponse
     * 添加班级
     */

    public function addclass(Request $request){
        $data = [];
        try{
            $class_id = $request -> input('c_id');
            $class_name = $request -> input('c_name');
            $teacher_id = $request ->id;

            if(!$class_id || !$class_name ){
                return apiResponse('401', '请输入班级id和名称！', $data) ;
            }
            if(!$teacher_id){
                return apiResponse('401', '教师id错误，请重新登录。', $data) ;
            }
            $data = Classid::addclass($class_id,$class_name,$teacher_id );

            if($data['code']=='1'){
                return apiResponse('0', '班级创建成功！', $data) ;
            } else{
                return apiResponse('401', '班级id已存在!', $data) ;
            }

        }catch (\Exception $e) {
            return $e;
            //return $this->internalErrRes();
        }



    }

    /**
     * @param Request $request
     * @return \Exception|\Illuminate\Http\JsonResponse
     * 删除班级
     */

    public function delclass(Request $request)
    {
        $data = [];
        try {
            $class_id = $request ->input('c_id');
            if(!$class_id){
                return apiResponse('401', '班级id不能为空！', $data) ;
            }
            $data = Classid::delclass($class_id);
            if($data['code'] == '1'){
                return apiResponse('0', '班级删除成功！', $data) ;
            }else{
                return apiResponse('401', '班级不存在！', $data) ;
            }





        }catch (\Exception $e) {
            return $e;
            //return $this->internalErrRes();
        }


    }



}
