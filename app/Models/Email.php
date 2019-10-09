<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    /**
     * @var bool 主键是否自增
     */
    public $incrementing = false;
    /**
     * @var bool 数据表包含created_at和updated_at字段
     */
    public $timestamps = false;
    /**
     * @var string 模型对应的数据表
     */
    protected $table = 'email_config';
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

    public static function getinfo(){
        $msg= Email::where('id','=','1')->first();
        if($msg){
            return $msg->server;
        }

    }

    public static function addinfo($data){
        Email::insert([
           'id' => $data['info'],
           'server' => $data['server']
        ]);
    }



}
