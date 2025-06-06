<?php
session_start();
require_once './db_utils.php';

$db_utils = new DB_UTILS;
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (empty($_GET['id'])) {
        $error_message = "Xin mời bạn nhập tên sản phẩm bạn muốn tìm kiếm";
    }
    if ($error_message == "") {
        $keyword = "%" . strtolower($_GET['id']) . "%";
        $query_search = "SELECT * FROM sanpham WHERE LOWER(tenSP) LIKE ?";
        $result_search = $db_utils->getAll($query_search, [$keyword]);
        if (!$result_search) {
            $error_message = "Sản phẩm bạn muốn tìm không tồn tại";
        } else {
            $sanpham = $result_search;
        }
    }
}
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
                <h4>Chi tiết sản phẩm</h4>
                <!-- form -->
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
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($sanpham)) : ?>
                            <?php foreach ($sanpham as $item) : ?>
                                <tr>
                                    <td><?= $item['maDM'] ?></td>
                                    <td><?= $item['maTH'] ?></td>
                                    <td><?= $item['maSP'] ?></td>
                                    <td><?= $item['tenSP'] ?></td>
                                    <td><?= $item['donGia'] ?></td>
                                    <td><?= $item['soLuong'] ?></td>
                                    <td><?= $item['hinhAnh'] ?></td>
                                    <td><?= $item['moTa'] ?></td>
                                    <td><?= $item['ngayTao'] ?></td>
                                    <td>
                                        <a class="btn btn-danger" href="delete_sanpham.php?id=<?= $item['maSP'] ?>">xoá</a>
                                        <a class="btn btn-info" href="edit_sanpham.php?id=<?= $item['maSP'] ?>">sửa</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="10" class="text-center text-danger">Không tìm thấy sản phẩm nào.</td>
                            </tr>
                        <?php endif; ?>
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