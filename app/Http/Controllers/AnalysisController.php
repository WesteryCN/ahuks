<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentExam;
use App\Http\Controllers\Controller;

class AnalysisController extends Controller
{

    public static function getmyscore(Request $request){
        if(!$request->input('exam_id')){
            return apiResponse('402', '考试id不能为空。') ;
        }
        try {
            $exam_id = $request->input('exam_id');
            $data = StudentExam::getmyscore($request->id, $exam_id);

            if($data['code'] == 1){
                return apiResponse('0', '成绩获取成功。',$data) ;
            }else{
                return apiResponse('402', '考试未开始，无法获取成绩。') ;
            }


        }catch (\Exception $e) {
            return $e;
            //return $this->internalErrRes();
        }



    }


    public static function gettotalinfo(Request $request){
        if(!$request->input('exam_id')){
            return apiResponse('402', '考试id不能为空。') ;
        }
        try {
            $data = [];
            $exam_id = $request->input('exam_id');
            //$data = StudentExam::getmyscore($request->id, $exam_id);

            if($data['code'] == 1){
                return apiResponse('0', '班级成绩获取成功。',$data) ;
            }else{
                return apiResponse('402', '班级考试信息获取失败。') ;
            }


        }catch (\Exception $e) {
            return $e;
            //return $this->internalErrRes();
        }



    }




}


