<?php
namespace App\Http\Middleware;
use Closure;
use App\Models\Student;

/**
 * 安徽大学数据库课程设计
 * 学生中间件模块
 * by: 刘方祥
 * i@2git.cn
 * i@westery.cn
 */


class CheckAndRenewTokenStudent
{
    public function handle($request, Closure $next)
    {
        $data=[];
        $token = $request->cookie('token');
        if (!$token) {
            $token = $request->header('token');
        }
        if (!$token) {
            $token = $request->input('token');
        }

        if (!$token) {
            return $this->tokenInvalidRes();
        }

        try {
            $user = Student::getUserByToken($token);

            if(!$user){
                return apiResponse('401',"token无效!",$token);
            }

        }catch (\Exception $e) {
            return $this->internalErrRes();
        }
        $data = [
            'user' => $user['user'],
            'name' => $user['name'],
            'token' => $user['token']
        ];
        Student::renewToken($token);
        $request->merge($data);
        return $next($request);

    }


    protected function internalErrRes()
    {
        return apiResponse('501', '系统内部错误');
    }


    protected function tokenInvalidRes()
    {
        return apiResponse('410', 'token无效');
    }









}
