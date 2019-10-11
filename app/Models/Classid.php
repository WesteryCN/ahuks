<?php


namespace App\Models;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 安徽大学数据库课程设计
 * 班级数据库部分
 * by: 刘方祥
 * i@2git.cn
 * i@westery.cn
 */

class Classid extends Model
{


    use SoftDeletes;//启动软删除
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    /**
     * @var bool 主键是否自增
     */
    public $incrementing = false;
    /**
     * @var bool 数据表包含created_at和updated_at字段
     */
    public $timestamps = true;
    /**
     * @var string 模型对应的数据表
     */
    protected $table = 'class';
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


    public static function listclass($class_id){
        if($class_id == -1){ //列出全部班级
            $data=['code'=>'0'];
            $user = Classid::where('id','>','0')->get();
            if($user){

                foreach ($user as $temp_user){
                    $t_temp = Teacher::getTeacherInfoById($temp_user ->t_id);

                    $data['class'][$temp_user->id] = array([
                        'class_name' => $temp_user->name,
                        't_id' => $temp_user->t_id,
                        //'t_info' => $t_temp,
                        't_name' => $t_temp['name'],
                    ]);
                }
                $data['code']='1';
            }
            else{
                $data['code']='0';
            }

            return $data;

        }else{
            $data=['code'=>'0'];
            $user2 = Classid::where('id','=',$class_id)->first();
            if($user2){
                $t_temp = Teacher::getTeacherInfoById($user2 ->t_id);
                $data['class'][$user2->id] = [
                    'class_name' => $user2->name,
                    't_id' => $user2->t_id,
                   // 't_info' => $t_temp,
                    't_name' => $t_temp['name'],
                ];

                $data['code']='1';
            }
            else{
                $data['code']='0';
            }

            return $data;

        }

    }





}
