<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
    /**
     * 安徽大学数据库课程设计
     * 教师数据库部分
     * by: 刘方祥
     * i@2git.cn
     * i@westery.cn
     */
class Teacher extends Model{
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
    public $incrementing = true;
    /**
     * @var bool 数据表包含created_at和updated_at字段
     */
    public $timestamps = true;
    /**
     * @var string 模型对应的数据表
     */
    protected $table = 'teacher';
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

    /**
     *登录模块，成功则置新的token
     */

    public static function getUser($userName, $psw)
    {
        $user = Teacher::where('t_number', $userName)->where('password',md5($psw) )->first();
        if ($user) {
            $token = substr(md5(strval(uniqid()). 'ahulfx' ), 0, 16);
            $user -> update([
                'token' => $token,
                'token_expired_at' => date('Y-m-d H:i:s', time() + 36000)
            ]);
            $data=[];
            $data['user'] = $userName;
            $data['token'] = $token;
            return $data;
        } else {
            return [];
        }
    }

    /**
     *通过token取出用户名
     */

    public static function getUserByToken($token)
    {
        $data=[];
        $time = date('Y-m-d H:i:s', time());
        $user = Teacher::where('token', $token)->where('token_expired_at', '>', $time)->first();
        if ($user) {
            $data['id'] = $user['id'];
            $data['user'] = $user['t_number'];
            $data['name'] = $user['name'];
            $data['token'] = $token;

            return $data;
        } else {
            return [];
        }



    }

    /**
     *更新token的有效时间
     */

    public static function renewToken($token)
    {
        Teacher::where('token', $token)->first()
            ->update([
                'token_expired_at' => date('Y-m-d H:i:s', time() + 36000)
            ]);
    }

    /**
     *使token失效
     */

    public static function tokenInvalidate($token)
    {
        $time = date('Y-m-d H:i:s', time());
        $user = Teacher::where('token', $token)->first();
        if ($user)
            $user->update([
                'token_expired_at' => $time
            ]);
    }

    /**
     *重置密码模块
     */

    public static function setPasswd($userName, $passwd)
    {
        $time = date('Y-m-d H:i:s', time());
        Teacher::where('t_number', $userName)->firstOrFail()
            ->update([
                'password' => md5($passwd),
                'token_expired_at' => $time
            ]);
    }

    /**
     * 通过id 获取教师信息
     */

    public static function getTeacherInfoById($t_id){
        $user = Teacher::where('id','=' ,$t_id)->first();
        $data = ['code' => '0'];
        if ($user)
            $data = [
                't_id' => $user ->id,
                't_number' => $user -> t_number,
                'name' => $user ->name,
                'code' => '1',
            ];

        return $data;
    }






}
