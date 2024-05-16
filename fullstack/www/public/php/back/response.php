<?php
    function sendResponse($istrue, $msg=""){
        $response = [
            'status' => $istrue,
            'msg' => $msg
        ];
        echo json_encode($response);
    }
?>