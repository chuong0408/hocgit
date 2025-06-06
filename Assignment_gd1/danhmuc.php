<?php
session_start();
require_once './db_utils.php';
$db_utils = new DB_UTILS;
$error_message = "";
if (!isset($_SESSION['user_id']) && empty($_SESSION['user_id']))
 {
    header("location: login.php");
    exit();
 };
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(empty($_POST['maDM'])){
        $error_message = "Mã danh mục không được để trống.";
    }
    if(empty($_POST['tenDM'])){
        $error_message = "Tên danh mục không được để trống.";
    }
    if($error_message == ""){
        $query_kiemtratontai = "SELECT * FROM danhmuc WHERE maDM = ?";
        $result_kiemtratontai = $db_utils->getOne($query_kiemtratontai,[$_POST['maDM']]);
        if(!$result_kiemtratontai){
            $query_insert = "INSERT INTO danhmuc(maDM,tenDM) VALUES (?,?)";
            $result_insert = $db_utils->execute($query_insert,[
                $_POST['maDM'],
                $_POST['tenDM']
            ]);
            $error_message = "Đã thêm thành công.";
        }else{
            $error_message = "Mã danh mục đã tồn tại.";
        }
    }
}
$_SESSION['message'] = $error_message;
$query = "SELECT * FROM danhmuc";
$danhmuc = $db_utils->getAll($query);
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Lab3</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container-fluid p-5 bg-primary text-white text-center">
        <h1>Dashboard</h1>
    </div>
    <div class="container mt-5">
                <div class="row">
            <?php include './includes/search.php' ?>
        </div>
        <div class="row">   
            <?php include "./includes/message.php" ?>
            <?php include "./includes/sidebar.php" ?>
            <div class="col-sm-8">
                <?php
                if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
                    echo "<div class='alert alert-info'>
  <strong>Info!</strong> $_SESSION[message]
</div>";
                }
                ?>
                <h4>Quản lý danh mục</h4>
                <!-- form -->
                <form method="post" action="">
                    <label class="form-label" for="ten">Mã danh mục: </label>
                    <input class="form-control" type="text" name="maDM">
                    <label class="form-label" for="">Tên Danh mục</label>
                    <input class="form-control" type="text" name="tenDM">
                    <!-- <?php
                    if (!empty($error_message)) {
                        echo "<span class='text-danger'>$error_message</span>";
                    }
                    ?> -->
                    <button type="sumbit" class="btn btn-primary mt-2" name="nut">Create</button>
                </form>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Mã Danh Mục</th>
                            <th>Tên Danh Mục</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($danhmuc) > 0) {
                            foreach ($danhmuc as $item) { ?>
                                <tr>
                                    <td><?php echo $item['maDM'] ?></td>
                                    <td><?php echo $item['tenDM'] ?></td>
                                    <td>
                                        <a class="btn btn-danger" href="delete_danhmuc.php?id=<?= $item['maDM'] ?>">xoá</a>
                                        <a class="btn btn-info" href="edit_danhmuc.php?id=<?= $item['maDM'] ?>">sửa</a>
                                    </td>
                                </tr>

                            <?php }
                            ?>



                        <?php  } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php 
        if(isset($_SESSION['message'])) {
            unset($_SESSION['message']);
        }
    ?>

</body>

</html>