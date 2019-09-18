<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model{

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
    public $timestamps = true;
    /**
     * @var string 模型对应的数据表
     */
    protected $table = 'student';
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
    protected $hidden = ['token_expired_at',];

    public static function getUser($userName, $psw)
    {


        $user = Student::where('s_number', $userName)->where('password', $psw)->first();

        if ($user) {
            return $user->toArray();
        } else {
            return [];
        }
    }


}
