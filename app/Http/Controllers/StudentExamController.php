<?php


namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Student;
use App\Models\ClassExam;
use App\Models\Classid;
use App\Models\Exam;

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

}
