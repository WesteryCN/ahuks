<?php

use App\Models\Classid;
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

            return apiResponse('0', '班级信息获取成功！', $data) ;
        }catch (\Exception $e) {
            return $e;
            //return $this->internalErrRes();
        }


    }




}
