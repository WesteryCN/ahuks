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




}
