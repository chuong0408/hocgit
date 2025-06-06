<?php
session_start();
require_once './db_utils.php';
$db_utils = new DB_UTILS;
$error_message = "";

$query_danhmuc = "SELECT * FROM danhmuc";
$danhmuc = $db_utils->getAll($query_danhmuc);
$query_thuonghieu = "SELECT * FROM thuonghieu";
$thuonghieu = $db_utils->getAll($query_thuonghieu);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['tenSP']) || empty($_POST['donGia']) || empty($_POST['soLuong']) || empty($_POST['hinhAnh']) || empty($_POST['moTa'])) {
        $error_message .= "Các trường dữ liệu không được để trống.<br>";
    }
    if ($_POST['donGia'] < 0 || $_POST['soLuong'] < 0) {
        $error_message .= "giá hoặc số lượng không được nhỏ hơn 0.<br>";
    }
    if ($error_message == "") {
        $query_checktontai = "SELECT * FROM sanpham WHERE maSP = ?";
        $result_checktontai = $db_utils->getOne($query_checktontai, [$_POST['maSP']]);
        if (!$result_checktontai) {
            $query_insert = "INSERT INTO sanpham(maSP,tenSP,donGia,soLuong,hinhAnh,moTa,ngayTao,maTH,maDM) VALUES (?,?,?,?,?,?,?,?,?)";
            $date = date('Y-m-d H:i:s');
            $result_insert = $db_utils->execute($query_insert, [
                $_POST['maSP'],
                $_POST['tenSP'],
                $_POST['donGia'],
                $_POST['soLuong'],
                $_POST['hinhAnh'],
                $_POST['moTa'],
                $date,
                $_POST['maTH'],
                $_POST['maDM']
            ]);
            if ($result_insert) {
                $_SESSION['message']['success'] = "Thêm sản phẩm thành công.";
                header("location: sanpham.php");
                exit();
            } else {
                $_SESSION['message']['error'] = "Thêm sản phẩm không thành công.";
                header("location: them_sanpham.php");
                exit();
            }
        } else {
            $_SESSION['message']['error'] = $error_message;
            header("location: sanpham.php");
            exit();
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
            <?php include "./includes/sidebar.php" ?>
            <div class="col-sm-8">
                <?php
                if (isset($_SESSION['message']) && !empty($_SESSION['message']['success'])) {
                    echo "<div class='alert alert-success'>" .
                        $_SESSION['message']['success'] .
                        "</div>";
                } else if (isset($_SESSION['message']) && !empty($_SESSION['message']['error'])) {
                    echo "<div class='alert alert-danger'>" .
                        $_SESSION['message']['error'] .
                        "</div>";
                }
                ?>
                <h4>Thêm mới sản phẩm</h4>
                <!-- form -->
                <form method="post" action="">
                    <label class="form-label" for="ten">Mã: </label>
                    <input class="form-control" value="<?php
                                                        echo uniqid();
                                                        ?>" type="text" name="maSP" readonly>
                    <label class="form-label" for="">Tên</label>
                    <input class="form-control" type="text" name="tenSP">
                    <label class="form-label" for="">Giá</label>
                    <input class="form-control" type="number" name="donGia">
                    <label class="form-label" for="">Số lượng</label>
                    <input class="form-control" type="number" name="soLuong">
                    <label class="form-label" for="">Thương hiệu</label>
                    <select name="maTH" class="form-control">
                        <?php foreach ($thuonghieu as $item): ?>
                            <option value="<?php echo $item['maTH'] ?>"><?php echo $item['tenTH'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label class="form-label" for="">Danh mục</label>
                    <select name="maDM" class="form-control">
                        <?php foreach ($danhmuc as $item): ?>
                            <option value="<?php echo $item['maDM'] ?>"><?php echo $item['tenDM'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label class="form-label" for="">hình ảnh</label>
                    <input class="form-control" type="text" name="hinhAnh">
                    <label class="form-label" for="">mô tả</label>
                    <textarea rows="4" class="form-control" name="moTa"></textarea>
                    <?php
                    if (!empty($error_message)) {
                        echo "<span class='text-danger'>$error_message</span>";
                    }
                    ?>
                    <button type="sumbit" class="btn btn-primary mt-2" name="nut">Create</button>
                </form>
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