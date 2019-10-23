<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
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
    protected $table = 'question';
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

    protected $casts = [
        'q_answers' => 'array',
        'right_answer'=> 'array',
        'stu_ans' => 'array'
    ];

    public static function isexist($exam_id,$q_rank){
        if( Question::where('exam_id','=',$exam_id) ->where('q_rank','=',$q_rank) ->first()){
            return 1;
        }else{
            return 0;
        }

    }

    public static function addquestion($data){
         if(Question::isexist($data['exam_id'],$data['q_rank'])){
             return 0;
         }
         //print_r($data);
         $question = Question::Create([
             'exam_id' => $data['exam_id'],
             'q_title' => $data['q_title'],
             'q_answers'=> $data['q_answers'],
             'type' => $data['type'],
             'q_mark' => $data['q_mark'],
             'q_rank' => $data['q_rank'],
             'right_answer' => $data['right_answer'],
         ]);
         return 1;




    }


    public static function leftscore($exam_id){
        $data = [];
        $data['code'] = 0;

        $questions = Question::where('exam_id','=',$exam_id)->get();
        if($questions) {
            $data['code'] = 1;
            $total_score = 0;
            foreach ($questions as $temp_question) {
                $total_score =$total_score + $temp_question->q_mark;
            }
            $exam = Exam::where('id', $exam_id)->first();
            $exam_score = $exam -> total_score;

            $data['left_score'] = $exam_score - $total_score ;
            return $data;



        }




        return 1;




    }

    public static function listquestion($exam_id){
        $data = [];
        $data['code'] = 0;

        $questions = Question::where('exam_id','=',$exam_id)->get();
        if($questions) {
            $data['code'] = 1;
            $data['exam_id'] = $exam_id;
            foreach ($questions as $temp_question) {
                $data['questions'][$temp_question->id] = array([
                    'q_id' => $temp_question->id,
                    'q_title' => $temp_question->q_title,
                    'q_answers'=>  $temp_question->q_answers ,
                    'type' => $temp_question->type,
                    'q_mark' =>$temp_question->q_mark,
                    'q_rank' => $temp_question->q_rank,
                    'right_answer' => $temp_question->right_answer,
                ]);
            }

            return $data;



        }




        return 1;




    }

    public static function delquestion($exam_id,$q_rank){
        $data = [];
        $data['code'] =0;
        if($q_rank == -1){
            $questions = Question::where('exam_id','=',$exam_id)->get();
            if($questions){
                foreach ($questions as $temp_question){
                    $temp_question ->delete();
                }
                $data['code'] =1;
            }
            return $data;
        }else{
            if($q_rank != -1){
                $question = Question::where('exam_id','=',$exam_id)->where('q_rank','=',$q_rank)->first();
                if($question){
                    $question ->delete();
                    $data['code'] =1;
                }
                return $data;
            }
        }


    }

    public static function listmyquestion($exam_id){
        $data = [];
        $data['code'] = 0;

        $questions = Question::where('exam_id','=',$exam_id)->get();
        if($questions) {
            $data['code'] = 1;
            $data['exam_id'] = $exam_id;
            foreach ($questions as $temp_question) {
                $data['questions'][$temp_question->id] = array([
                    'q_id' => $temp_question->id,
                    'q_title' => $temp_question->q_title,
                    'q_answers'=>  $temp_question->q_answers ,
                    'type' => $temp_question->type,
                    'q_mark' =>$temp_question->q_mark,
                    'q_rank' => $temp_question->q_rank,
                    //'right_answer' => $temp_question->right_answer,
                ]);
            }

            return $data;



        }




        return 1;




    }


}
