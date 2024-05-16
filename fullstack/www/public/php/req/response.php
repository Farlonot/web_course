<?php
    function sendResponse($status, $msg="", $info=null, $code=200){
        $response = [
            'status' => $status,
            'msg' => $msg,
            'info' => $info
        ];
        echo json_encode($response);
        #http_response_code($code);
    }
?>