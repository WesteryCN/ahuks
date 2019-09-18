<?php
namespace App\Http\Middleware;
use Closure;
class CheckAndRenewTokenTeacher
{
    public function handle($request, Closure $next)
    {
        $token = $request->cookie('token');// || $request->input('token');
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
            if ($token =='111'){
                $user = 'lfx';
            }else{
                return $this->tokenInvalidRes();
            }




        }catch (\Exception $e) {
            return $this->internalErrRes();
        }

        $user = [
            'user' => $user
        ];
        $request->merge($user);
        return $next($request);

    }


    protected function internalErrRes()
    {
        return apiResponse('501', '系统内部错误');
    }

    protected function roleErrRes()
    {
        return apiResponse('411', '操作权限不足');
    }

    protected function tokenInvalidRes()
    {
        return apiResponse('410', 'token无效');
    }









}
