<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
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
    protected $table = 'exam';
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

    public static function isreal($exam_id){
        $user = Exam::where('id','=',$exam_id)->first();
        if($user){
            return 1;
        }
        return 0;
    }

    public static function getidbyname($exam_name){
        $user = Exam::where('name','=',$exam_name)->first();
        if($user){
            return $user->id;
        }
        return 0;
    }

    public static function getnamebyid($exam_id){
        $user = Exam::where('id','=',$exam_id)->first();
        if($user){
            return $user->name;
        }
        return 0;
    }


    public static function addexam($data){
        $exam = Exam::where('name', $data['exam_name'])->first();
        if($exam){
            return 0;//考试已存在
        }else{
            $exam = Exam::insert([
                'name' => $data['exam_name'],
                'place' => $data['place'],
                'start_at' => $data['start_at'],
                'end_at' => $data['end_at'],
                'total_score' => $data['total_score'],
                'note' => $data['note'],

            ]);
            return 1;//考试创建完毕
        }

    }


    public static function listexam($exam_id){
        if($exam_id != -1){
            $data=[];
            $exam = Exam::where('id','=',$exam_id) ->get();
            if($exam){
                $temp_i =1;
                foreach ($exam as $temp_exam){
                    $data['exam'][$temp_exam->id] = array([
                        'id' => $temp_exam->id,
                        'name' => $temp_exam->name,
                        'place' => $temp_exam->place,
                        'start_at' => $temp_exam->start_at,
                        'end_at' => $temp_exam->end_at,
                        'note' => $temp_exam->note,

                    ]);
                }
                $data['code']='1';
            }
            else{
                $data['code']='0';
            }

            return $data;
        }
        $data=[];
        $exam = Exam::where('id','>','0')->get();
        if($exam){
            $temp_i =1;
            foreach ($exam as $temp_exam){
                $data['exam'][$temp_exam->id] = array([
                    'id' => $temp_exam->id,
                    'name' => $temp_exam->name,
                    'place' => $temp_exam->place,
                    'start_at' => $temp_exam->start_at,
                    'end_at' => $temp_exam->end_at,
                    'note' => $temp_exam->note,
                ]);
            }
            $data['code']='1';
        }
        else{
            $data['code']='0';
        }

        return $data;
    }



    public static function delexam($exam_id){
        $exam = Exam::where('id', $exam_id)->first();
        if($exam){
            $exam->delete();
            return 1;//用户删除成功
        }else{
            return 0;//用户不存在
        }

    }


}
