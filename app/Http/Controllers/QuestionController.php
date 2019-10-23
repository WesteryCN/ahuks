<?php


namespace App\Http\Controllers;

use App\Models\Classid;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Teacher;
use Illuminate\Http\Request;


class QuestionController extends Controller
{

    public static function addquestion(Request $request){
        $data = [];
        if(!$request->input('exam_id') or !$request->input('q_rank')){
            return apiResponse('402', '考试id和考题序号不能为空。') ;
        }
        if(!Exam::isreal($request->input('exam_id'))){
            return apiResponse('402', '考试id不存在。') ;
        }
        $score =Question::leftscore($request->input('exam_id'));

        if($score['left_score'] < $request->input('q_mark')){
            return apiResponse('402', '考题分数超出试题设定。') ;
        }

        try{
            $data['exam_id'] = $request->input('exam_id');
            $data['q_title'] = $request->input('q_title');
            $data['q_answers'] =(array) $request->input('q_answers');
            $data['type'] = $request->input('q_type');
            $data['q_mark'] = $request->input('q_mark');
            $data['q_rank'] = $request->input('q_rank');
            $data['right_answer'] = (array)$request->input('right_answer');

            $data2 = Question::addquestion($data);



            if($data2 == '1'){
                return apiResponse('0', '考题插入成功！') ;
            }else{
                return apiResponse('401', '考题已存在！') ;
            }
        }catch (\Exception $e) {
            return $e;
            //return $this->internalErrRes();
        }


    }

    public static function leftscore(Request $request){
        $data = [];
        if(!$request->input('exam_id') ){
            return apiResponse('402', '考试id不能为空。') ;
        }
        if(!Exam::isreal($request->input('exam_id'))){
            return apiResponse('402', '考试id不存在。') ;
        }
        try{
            $exam_id =$request->input('exam_id');
            $data = Question::leftscore($exam_id);

            if($data['code'] == '1'){
                return apiResponse('0', '查询考题剩余分数成功！',$data) ;
            }else{
                return apiResponse('401', '查询失败！',$data) ;
            }
        }catch (\Exception $e) {
            return $e;
            //return $this->internalErrRes();
        }


    }

    public static function listquestion(Request $request){
        $data = [];
        if(!$request->input('exam_id') ){
            return apiResponse('402', '考试id不能为空。') ;
        }
        try{
            $exam_id =$request->input('exam_id');
            $data = Question::listquestion($exam_id);

            if($data['code'] == '1'){
                return apiResponse('0', '查询考题成功！',$data) ;
            }else{
                return apiResponse('401', '考题不存在！',$data) ;
            }
        }catch (\Exception $e) {
            return $e;
            //return $this->internalErrRes();
        }


    }

    public static function delquestion(Request $request){
        $data = [];
        if(!$request->input('exam_id') ){
            return apiResponse('402', '考试id不能为空。') ;
        }else{
            $exam_id =$request->input('exam_id');
        }
        if(!$request->input('q_rank') ){
            $q_rank = -1 ;
        }else{
            $q_rank = $request->input('q_rank');
        }

        try{
            $data = Question::delquestion($exam_id,$q_rank);
            if($data['code'] == '1'){
                return apiResponse('0', '删除考题成功！',$data) ;
            }else{
                return apiResponse('401', '考题不存在！',$data) ;
            }
        }catch (\Exception $e) {
            return $e;
            //return $this->internalErrRes();
        }


    }




}
