<?php
session_start();
require_once './db_utils.php';
$db_utils = new DB_UTILS;
$error_message = "";

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(!empty($_GET['id'])){
        $query_delete = "DELETE FROM danhmuc WHERE maDM = ?";
        $result_delete = $db_utils->execute($query_delete,[$_GET['id']]);
        $error_messager = "Đã xóa thành công";
        $_SESSION['message'] = $error_message;
        header("location: danhmuc.php");
        exit();
    }else{
        $_SESSION['message'] = "ID không tồn tại";
        header("location: danhmuc.php");
        exit();
    }
}

