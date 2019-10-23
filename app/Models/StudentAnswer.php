<?php


namespace App\Models;

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
        return 1;





    }








}
