<?php
    function redirect($url="../index.php"){
        header("Location: ".$url);
        exit;
    }
?>