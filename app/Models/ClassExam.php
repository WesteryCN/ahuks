<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassExam extends Model
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    /**
     * @var bool 主键是否自增
     */
    public $incrementing = true;
    /**
     * @var bool 数据表包含created_at和updated_at字段
     */
    public $timestamps = false;
    /**
     * @var string 模型对应的数据表
     */
    protected $table = 'class_exam';
    /**
     * @var string 主键名
     */
    protected $primaryKey = 'id';
    /**
     * @var string 主键类型
     */
    protected $keyType = 'int';
    /**
     * @var array 为空，则所有字段可集体赋值
     */
    protected $guarded = [];
    /**
     * @var array 序列化时隐藏的字段
     */
    protected $hidden = [];

    public static function isreal($exam_id,$class_id){
        $user = ClassExam::where('exam_id','=',$exam_id)->where('class_id','=',$class_id)->first();
        if($user){
            return 1;
        }else{
            return 0;
        }
    }

    public static function linkexam($exam_id,$class_id){
        $user = ClassExam::where('exam_id','=',$exam_id)->where('class_id','=',$class_id)->first();
        if($user){
            return 0;
        }else{
            ClassExam::insert([
                'exam_id' => $exam_id,
                'class_id' => $class_id,

            ]);
            return 1;
        }



    }


    public static function dellink2($class_id,$exam_id)
    {
        $user = ClassExam::where('class_id', $class_id)->where('exam_id', $exam_id)->first();
        if (!$user) {
            return 0;
        } else {
            $user->delete();
            return 1;
        }
    }

    public static function dellink($link_id){
        $user = ClassExam::where('id','=',$link_id)->first();
        if(!$user){
            return 0;
        }else{
            $user->delete();
            return 1;
        }



    }

    public static function listlink($exam_id,$class_id){
        $data =[];
        $data['code']='0';
        if( ($exam_id != -1) and ($class_id != -1)){
            $data=[];
            $exam = ClassExam::where('exam_id','=',$exam_id)->where('class_id','=',$class_id) ->get();
            if($exam){
                foreach ($exam as $temp_exam){
                    $data['exam'][$temp_exam->id] = array([
                        'id' => $temp_exam->id,
                        'class_id' => $temp_exam->class_id,
                        'class_name' => Classid::getnamebyid($temp_exam->class_id) ,
                        //'exam_id' => $temp_exam->exam_id,
                        //'exam_name' => Exam::getnamebyid($temp_exam->exam_id),
                        'exam_info' => Exam::listexam($temp_exam->exam_id)['exam'][$temp_exam->exam_id],

                    ]);
                }
                $data['code']='1';
            }
            else{
                $data['code']='0';
            }
            return $data;
        }
        if( ($exam_id == -1) and ($class_id == -1)){
            $data=[];
            $exam = ClassExam::where('id','>','0') ->get();
            if($exam){
                foreach ($exam as $temp_exam){
                    $data['exam'][$temp_exam->id] = array([
                        'id' => $temp_exam->id,
                        'class_id' => $temp_exam->class_id,
                        'class_name' => Classid::getnamebyid($temp_exam->class_id) ,
                        //'exam_id' => $temp_exam->exam_id,
                        //'exam_name' => Exam::getnamebyid($temp_exam->exam_id),
                        'exam_info' => Exam::listexam($temp_exam->exam_id)['exam'][$temp_exam->exam_id],

                    ]);
                }
                $data['code']='1';
            }
            else{
                $data['code']='0';
            }
            return $data;
        }
        if( ($exam_id == -1) and ($class_id != -1)){
            $data=[];
            $exam = ClassExam::where('exam_id','>','0')->where('class_id','=',$class_id) ->get();
            if($exam){
                foreach ($exam as $temp_exam){
                    $data['exam'][$temp_exam->id] = array([
                        'id' => $temp_exam->id,
                        'class_id' => $temp_exam->class_id,
                        'class_name' => Classid::getnamebyid($temp_exam->class_id) ,
                        //'exam_id' => $temp_exam->exam_id,
                        //'exam_name' => Exam::getnamebyid($temp_exam->exam_id),
                        'exam_info' => Exam::listexam($temp_exam->exam_id)['exam'][$temp_exam->exam_id],

                    ]);
                }
                $data['code']='1';
            }
            else{
                $data['code']='0';
            }
            return $data;
        }
        if( ($exam_id != -1) and ($class_id == -1)){
            $data=[];
            $exam = ClassExam::where('exam_id','=',$exam_id)->where('class_id','>','0') ->get();
            if($exam){
                foreach ($exam as $temp_exam){
                    $data['exam'][$temp_exam->id] = array([
                        'id' => $temp_exam->id,
                        'class_id' => $temp_exam->class_id,
                        'class_name' => Classid::getnamebyid($temp_exam->class_id) ,
                        //'exam_id' => $temp_exam->exam_id,
                        //'exam_name' => Exam::getnamebyid($temp_exam->exam_id),
                        'exam_info' => Exam::listexam($temp_exam->exam_id)['exam'][$temp_exam->exam_id],

                    ]);
                }
                $data['code']='1';
            }
            else{
                $data['code']='0';
            }
            return $data;
        }

    }

    public static function listmylink($s_id,$class_id,$status){
        $data =[];
        $data['code']='0';
            $data=[];
            $exam = ClassExam::where('exam_id','>','0')->where('class_id','=',$class_id) ->get();
            if($exam){
                foreach ($exam as $temp_exam){
                    $temp_status = StudentExam::check($s_id,$temp_exam->exam_id);
                    if($status != "-1"){
                        if($temp_status != $status){
                            if($status == 2 and $temp_status ==3){

                            }else{
                                continue;
                            }

                        }
                    }

                    $data['exam'][$temp_exam->id] = array([
                        'id' => $temp_exam->id,
                        'class_id' => $temp_exam->class_id,
                        'class_name' => Classid::getnamebyid($temp_exam->class_id) ,
                        //'exam_id' => $temp_exam->exam_id,
                        //'exam_name' => Exam::getnamebyid($temp_exam->exam_id),
                        'exam_status' => StudentExam::check($s_id,$temp_exam->exam_id),
                        'exam_info' => Exam::listexam($temp_exam->exam_id)['exam'][$temp_exam->exam_id],

                    ]);
                }
                $data['code']='1';
            }
            else{
                $data['code']='0';
            }
            return $data;

    }














}
