<?php
    $pdo = new PDO('mysql:host=phplab_mysql;dbname=phplab;charset=utf8', 'root', 'InsanePassword');
    function bindNullValue($stmt, $name){
        if (!isset($_POST[$name]) || $_POST[$name] === null || $_POST[$name] === '') {
            $stmt->bindValue(':'.$name, null, PDO::PARAM_NULL); // Передача NULL
        } else {
            $stmt->bindParam(':'.$name, $_POST[$name]);
        }
    }
?>