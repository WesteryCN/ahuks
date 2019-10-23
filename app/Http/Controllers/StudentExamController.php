<?php


namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Student;
use App\Models\ClassExam;
use App\Models\StudentAnswer;
use App\Models\StudentExam;

use Illuminate\Http\Request;


class StudentExamController extends Controller
{
    public function getmyexam(Request $request)
    {
        try{
            $class_id = Student::getclassid($request->user);
            $data = ClassExam::listlink('-1',$class_id);
            return apiResponse('0', '学生考试获取成功！', $data) ;

        }catch (\Exception $e) {
            return $e;
            //return $this->internalErrRes();
        }
    }

    public function getmyexamquestion(Request $request)
    {
        if(!$request->input('exam_id') ){
            return apiResponse('402', '考试id不能为空。') ;
        }

        try{
            $class_id = Student::getclassid($request->user);
            $exam_id = $request->input('exam_id');
            if(!ClassExam::isreal($exam_id,$class_id)){
                return apiResponse('301', '无权限访问非本班的试卷。') ;
            }
            $data = Question::listmyquestion($exam_id);
            return apiResponse('0', '学生考试考题获取成功！', $data) ;

        }catch (\Exception $e) {
            return $e;
            //return $this->internalErrRes();
        }
    }

    //开始答题
    public static function startask(Request $request){
        $data = [];
        if(!$request->input('exam_id') ){
            return apiResponse('402', '考试id不能为空。') ;
        }else{
            $exam_id =$request->input('exam_id');
        }
        try{
            $data = StudentExam::startask($request->id,$exam_id);
            if($data == 1){
                return apiResponse('0', '提交考试开始请求成功！') ;
            }else{
                return apiResponse('402', '考试已经开始！') ;
            }


        }catch (\Exception $e) {
            return $e;
            //return $this->internalErrRes();
        }




    }


    //结束答题并提交答案
    public static function endask(Request $request){
        $data = [];
        if(!$request->input('exam_id') || !$request->input('stu_ans') ){
            return apiResponse('402', '考试id、题目答案不能为空。') ;
        }else{
            $exam_id =$request->input('exam_id');
            if(!$request->input('cheat')){
                $cheat = '0';
            }else{
                $cheat = $request->input('cheat');
            }

        }

        try{
            $stu_ans =$request->input('stu_ans');
            $data = StudentExam::endask($request->id,$exam_id,$stu_ans,$cheat);
            if($data == 1){
                return apiResponse('0', '提交考试结束请求成功！') ;
            }else{
                return apiResponse('402', '考试尚未开始！',$data) ;
            }


        }catch (\Exception $e) {
            return $e;
            //return $this->internalErrRes();
        }




    }


}
