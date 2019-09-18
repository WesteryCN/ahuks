<?php

    function apiResponse($code, $msg, $data=[]) {
        return response()->json([
            'code' => $code,
            'msg' => $msg,
            'data' => $data
        ]);
    }

    function currentDatetime() {
        return date('Y-m-d H:i:s', time());
    }


?>