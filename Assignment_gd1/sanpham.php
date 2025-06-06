<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
session_start();
require_once './db_utils.php';
$db_utils = new DB_UTILS;
$error_message = "";
if (!isset($_SESSION['user_id']) && empty($_SESSION['user_id']))
 {
    header("location: login.php");
    exit();
 };
$query = "SELECT * FROM sanpham sp LEFT JOIN danhmuc dm on sp.maDM = dm.maDM LEFT JOIN thuonghieu th on sp.maTH = th.maTH";
$list_sanpham = $db_utils->getAll($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap 5 Example</title>
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
            <?php include './includes/sidebar.php'; ?>
            <div class="col-sm-8">
                <?php include "./includes/message.php" ?>
                <h4>Quản lý sản phẩm</h4>
                <!-- form -->
                <a href="them_sanpham.php" class="btn btn-success">Thêm mới</a>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tên Danh Mục</th>
                            <th>Tên Thương hiệu</th>
                            <th>Mã SP</th>
                            <th>Tên SP</th>
                            <th>Đơn Giá</th>
                            <th>Số Lượng</th>
                            <th>Hình Ảnh</th>
                            <th>Mô tả</th>
                            <th>Ngày tạo</th>
                            <th>Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($list_sanpham) > 0) {
                            foreach ($list_sanpham as $item) { ?>
                                <tr>
                                    <td><?php echo $item['maDM'] ?></td>
                                    <td><?php echo $item['maTH'] ?></td>
                                    <td><?php echo $item['maSP'] ?></td>
                                    <td><?php echo $item['tenSP'] ?></td>
                                    <td><?php echo $item['donGia'] ?></td>
                                    <td><?php echo $item['soLuong'] ?></td>
                                    <td><?php echo $item['hinhAnh'] ?></td>
                                    <td><?php echo $item['moTa'] ?></td>
                                    <td><?php echo $item['ngayTao'] ?></td>
                                    <td>
                                        <a class="btn btn-danger" href="delete_sanpham.php?id=<?= $item['maSP'] ?>">xoá</a>
                                        <a class="btn btn-info" href="edit_sanpham.php?id=<?= $item['maSP'] ?>">sửa</a>
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
    if (isset($_SESSION['message'])) {
        unset($_SESSION['message']);
    }
    ?>

</body>

</html>