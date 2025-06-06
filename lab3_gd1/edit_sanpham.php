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
    if($error_message == ""){
          $query_update = "UPDATE sanpham set tenSp = ?, donGia =?, soLuong =?,maTH =?,maDM =?,hinhAnh =?,moTa = ?  where maSP = ?";
          $result_update = $db_utils->execute($query_update,[
            $_POST['tenSP'],
            $_POST['donGia'],
            $_POST['soLuong'],
            $_POST['maTH'],
            $_POST['maDM'],
            $_POST['hinhAnh'],
            $_POST['moTa'],
            $_GET['id']
          ]);
          $_SESSION['message'] = "Cập nhật thành công.";
          header('location: sanpham.php');
          exit();
    }
}
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(!empty($_GET['id'])){
        $query_get_detail  = "SELECT * FROM sanpham WHERE maSP =?";
        $sanpham = $db_utils->getOne($query_get_detail,[$_GET['id']]);
if (count($sanpham) > 0) { ?>
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

                        <?php include './includes/sidebar.php' ?>
                        <div class="col-sm-8">
                            <h4>Sửa danh mục</h4>
                            <!-- form -->
                <form method="post" action="">
                    <label class="form-label" for="ten">Mã: </label>
                    <input class="form-control" value="<?php
                                                        echo uniqid();
                                                        ?>" type="text" name="maSP" readonly>
                    <label class="form-label" for="">Tên</label>
                    <input class="form-control" type="text" name="tenSP" value="<?php echo $sanpham['tenSP'] ?>">
                    <label class="form-label" for="">Giá</label>
                    <input class="form-control" type="number" name="donGia" value="<?php echo $sanpham['donGia'] ?>">
                    <label class="form-label" for="">Số lượng</label>
                    <input class="form-control" type="number" name="soLuong" value="<?php echo $sanpham['soLuong'] ?>">
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
                    <input class="form-control" type="text" name="hinhAnh" value="<?php echo $sanpham['hinhAnh'] ?>">
                    <label class="form-label" for="">mô tả</label>
                    <textarea rows="4" class="form-control" name="moTa"><?php echo $sanpham['moTa'] ?></textarea>
                    <?php
                    if (!empty($error_message)) {
                        echo "<span class='text-danger'>$error_message</span>";
                    }
                    ?>
                    <button type="sumbit" class="btn btn-primary mt-2" name="nut">Update</button>
                </form>
                        </div>
                    </div>
                </div>
    <?php     } else {
            echo "Id không tồn tại";
        }
    }
} ?>
    <?php
    if (isset($_SESSION['message'])) {
        unset($_SESSION['message']);
    }
    ?>
            </body>

            </html>
