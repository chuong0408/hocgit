<?php
session_start();
if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id']))
 {
    header("location: sanpham.php");
    exit();
 }else{
    $_SESSION['message'] = "Đăng nhập để sử dụng";
    header("location: login.php");
    exit();
 }