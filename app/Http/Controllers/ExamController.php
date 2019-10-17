<?php


namespace App\Http\Controllers;

use App\Models\Classid;
use App\Models\Exam;

use Illuminate\Http\Request;

/**
 * 安徽大学数据库课程设计
 *  考试管理模块
 * by: 刘方祥
 * i@2git.cn
 * i@westery.cn
 */


class ExamController extends Controller
{

    public function addexam(Request $request){
        $data = [];
        if(!$request->input('exam_name') or !$request->input('start_at') or !$request->input('end_at')or !$request->input('total_score')){
            return apiResponse('402', '考试名、时间、总分不能为空。') ;
        }
        try{
            $data['exam_name'] = $request->input('exam_name');
            $data['place'] = $request->input('place');
            $data['start_at'] = $request->input('start_at');
            $data['end_at'] = $request->input('end_at');
            $data['total_score'] = $request->input('total_score');
            $data['note'] = $request->input('note');


           $code = Exam::addexam($data);
            if($code == 1){
                return apiResponse('0', '考试创建成功！',$data) ;

            }else{
                return apiResponse('401', '考试已存在。') ;
            }

        }catch (\Exception $e) {
            return $e;
            //return $this->internalErrRes();
        }



    }


    public function listexam(Request $request){
        $exam_id = $request ->input('exam_id');
        if ($exam_id ==  null)
            $exam_id = -1;
        $data = [];
        $data2 = [];
        try{
            $data2 = Exam::listexam($exam_id);
            if ($data2['code']=='1'){
                if(sizeof($data2) >1)
                    $data = $data2['exam'];
                return apiResponse('0', '获取考试信息成功！', $data) ;
            }
        }catch (\Exception $e) {
            return $e;
            //return $this->internalErrRes();
        }

    }


    public function delexam(Request $request){
        $data = [];
        if(!$request->input('exam_id')){
            return apiResponse('402', '考试id不能为空。') ;
        }
        try{
            $code = Exam::delexam(  $request->input('exam_id'));
            if($code == 1){
                return apiResponse('0', '考试删除成功！',$data) ;

            }else{
                return apiResponse('401', '考试不存在。') ;
            }

        }catch (\Exception $e) {
            return $e;
            //return $this->internalErrRes();
        }



    }


}
