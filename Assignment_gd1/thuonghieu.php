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
    if(empty($_POST['maTH'])){
        $error_message = "Mã danh mục không được để trống.";
    }
    if(empty($_POST['tenTH'])){
        $error_message = "Tên danh mục không được để trống.";
    }
    if($error_message == ""){
        $query_kiemtratontai = "SELECT * FROM thuonghieu WHERE maTH = ?";
        $result_kiemtratontai = $db_utils->getOne($query_kiemtratontai,[$_POST['maTH']]);
        if(!$result_kiemtratontai){
            $query_insert = "INSERT INTO thuonghieu(maTH,tenTH) VALUES (?,?)";
            $result_insert = $db_utils->execute($query_insert,[
                $_POST['maTH'],
                $_POST['tenTH']
            ]);
            $error_message = "Đã thêm thành công.";
        }else{
            $error_message = "Mã danh mục đã tồn tại.";
        }
    }
}
$_SESSION['message'] = $error_message;
$query = "SELECT * FROM thuonghieu";
$thuonghieu = $db_utils->getAll($query);
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
                <h4>Quản lý thương hiệu</h4>
                <!-- form -->
                <form method="post" action="">
                    <label class="form-label" for="ten">Mã thương hiệu: </label>
                    <input class="form-control" type="text" name="maTH">
                    <label class="form-label" for="">Tên thương hiệu</label>
                    <input class="form-control" type="text" name="tenTH">
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
                            <th>Mã thương hiệu</th>
                            <th>Tên thương hiệu</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($thuonghieu) > 0) {
                            foreach ($thuonghieu as $item) { ?>
                                <tr>
                                    <td><?php echo $item['maTH'] ?></td>
                                    <td><?php echo $item['tenTH'] ?></td>
                                    <td>
                                        <a class="btn btn-danger" href="delete_thuonghieu.php?id=<?= $item['maTH'] ?>">xoá</a>
                                        <a class="btn btn-info" href="edit_thuonghieu.php?id=<?= $item['maTH'] ?>">sửa</a>
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