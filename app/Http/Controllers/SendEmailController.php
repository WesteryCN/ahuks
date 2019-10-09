<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\Sendemail;
use App\Models\Email;
use App\Http\Controllers\Controller;

class SendEmailController extends Controller
{
    /**
     * Store a new podcast.
     *
     * @param Request $request
     * @return Response
     */
    public function send(Request $request)
    {
        try{
            $data =[];
            $data['info'] = $request ->input('info');
            $data['server'] = Email::getinfo();

            Sendemail::dispatch($data);

            return apiResponse('0','邮件发送成功!');

        }catch (\Exception $e) {
            return $e;
            //return $this->internalErrRes();
        }

    }
}


