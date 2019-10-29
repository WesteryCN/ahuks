<?php


namespace App\Models;

use App\Jobs\Judge;
use Illuminate\Database\Eloquent\Model;

class StudentAnswer extends Model
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
    protected $table = 'student_answer';
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
        'stu_ans' => 'array',
        'answer' => 'array'
    ];


    public static function handleask($s_id,$exam_id,$stu_ans){
        //return $stu_ans;
        foreach ($stu_ans as $q_id =>  $temp_ans){
            //return $temp_ans ;
            StudentAnswer::updateOrCreate([
                's_id' => $s_id,
                'exam_id' => $exam_id,
                'q_id' => $q_id,

            ],[
                'answer' => $temp_ans
            ]);

        }
        Judge::dispatch($s_id,$exam_id);
        //return Self::judgeask($s_id,$exam_id);
        return 1;
    }

    public static function judgeask($s_id,$exam_id){
        $data=[];
        $iscorrect = 0;
        $mark_a =0;
        $mark_b =0;
        $tol_mark = 0;
        $t_ask = StudentAnswer::where('s_id',$s_id)->where('exam_id',$exam_id)->get();
        foreach ($t_ask as $temp_ask){
            $q_id = $temp_ask ->q_id;
            $t_ans = $temp_ask ->answer;
            $right = Question::where('id',$q_id)->first();
            $right_ans = $right->right_answer;
            $right_mark = $right->q_mark;
            $right_type = $right->type;
            if($t_ans == $right_ans){
                $iscorrect = 1;
                if($right_type == 1){
                    $mark_a =$mark_a +$right_mark;
                }else{
                    $mark_b =$mark_b +$right_mark;
                }

            }else{
                $iscorrect = 0;
            }
            $temp_ask ->update([
                's_right'=>$iscorrect,
            ]);

            //$data[$q_id]['t_ans'] = $t_ans;
            //$data[$q_id]['right_ans'] = $right_ans;
            //$data[$q_id]['is'] = $iscorrect;
        }
        $tol_mark = $mark_a + $mark_b;
        StudentExam::where('s_id',$s_id)->where('exam_id',$exam_id)->first()->update([
            'status' => '3',
            'total_score' => $tol_mark,
            'score1' => $mark_a,
            'score2' => $mark_b,
        ]);

        return 1;




    }




}
