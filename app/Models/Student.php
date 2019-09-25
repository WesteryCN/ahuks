<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

    /**
     * 安徽大学数据库课程设计
     * 学生数据库部分
     * by: 刘方祥
     * i@2git.cn
     * i@westery.cn
     */
class Student extends Model{
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

    /**
     *登录模块，成功则置新的token
     */

    public static function getUser($userName, $psw)
    {
        $user = Student::where('s_number', $userName)->where('password',md5($psw) )->first();
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
        $user = Student::where('token', $token)->where('token_expired_at', '>', $time)->first();
        if ($user) {
            $data['user'] = $user['s_number'];
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
        Student::where('token', $token)->first()
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
        $user = Student::where('token', $token)->first();
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
        Student::where('s_number', $userName)->firstOrFail()
            ->update([
                'password' => md5($passwd),
                'token_expired_at' => $time
            ]);
    }

    public static function liststd(){
        $data=[];
        $user = Student::where('id','>','0')->get();
        if($user){
            $temp_i =1;
            foreach ($user as $temp_user){
                $data['std'][$temp_user->id] = array([
                    's_number' => $temp_user->s_number,
                    's_name' => $temp_user->name
                ]);
            }
            $data['code']='1';
        }
        else{
            $data['code']='0';
        }

        return $data;
    }

    public static function addone($userName, $name, $passwd){
        $user = Student::where('s_number', $userName)->first();
        if($user ){
            return 1;//用户已存在
        }else{
            $user = Student::insert([
                's_number' => $userName,
                'name' => $name,
                'password' => md5($passwd),
                'created_at' => date('Y-m-d H:i:s', time()),
            ]);
            return 2;//用户创建完毕
        }

    }


    public static function delone($userName){
        $user = Student::where('s_number', $userName)->first();
        if($user ){
            $user = Student::where(['s_number' => $userName])->delete();
            return 2;//用户删除成功
        }else{
            return 1;//用户不存在
        }

    }


}
