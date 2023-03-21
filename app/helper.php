<?php

if(!function_exists('success')){
    function success($message = null, $data = [],$data2 =[], $status = 200,)
    {
        $response = [
            'status'    =>  $status,
            'message'   =>  $message ?? 'Process is successfully completed',
            'data'      =>  $data
        ];

        return response()->json($response,$status);
    }
}

if(!function_exists('NotSuccess')){
    function NotSuccess($message = null, $data = [], $status = 404,)
    {
        $response = [
            'status'    =>  $status,
            'message'   =>  $message ?? 'Process is successfully completed',
            'data'      =>  $data
        ];

        return response()->json($response,$status);
    }
}



?>