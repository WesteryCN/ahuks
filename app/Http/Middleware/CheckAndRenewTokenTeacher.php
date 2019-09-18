<?php
namespace App\Http\Middleware;
use Closure;
use App\Models\Teacher;
class CheckAndRenewTokenTeacher
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
            $user = Teacher::getUserByToken($token);

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
        Teacher::renewToken($token);
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
