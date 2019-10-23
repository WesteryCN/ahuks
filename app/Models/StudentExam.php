<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentExam extends Model
{
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
    protected $table = 'student_exam';
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
    protected $casts = [
        'q_answers' => 'array',
        'right_answer'=> 'array',
        'stu_ans' => 'array'
    ];


    public static function startask($s_id,$exam_id){
        $user = StudentExam::where('s_id',$s_id)->where('exam_id',$exam_id)->first();
        if($user){
            return 0;//已经开始
        }else{
            $user = StudentExam::insert([
                's_id' => $s_id,
                'exam_id' => $exam_id,
                'status' => '1',
                'start_ans_at' => date('Y-m-d H:i:s', time()),
                'cheat' => '0',
            ]);
            return 1;
        }

    }

    public static function check($s_id,$exam_id){
        $user = StudentExam::where('s_id',$s_id)->where('exam_id',$exam_id)->first();
        if(!$user){
            return '0';//没有开始
        }else {
            return $user->status;
        }
    }


    public static function endask($s_id,$exam_id,$stu_ans,$cheat){
        $user = StudentExam::where('s_id',$s_id)->where('exam_id',$exam_id)->first();
        if(!$user){
            return 0;//尚未开始
        }else{
            $data = StudentAnswer::handleask($s_id,$exam_id,$stu_ans);
            if ($data == "1"){
                $user -> update([
                    'status' => '2',
                    'cheat' => $cheat,
                ]);
                return 1;
            }else{
                return $data;
            }


        }

    }


}
