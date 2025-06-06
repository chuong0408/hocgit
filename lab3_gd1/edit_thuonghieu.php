<?php
session_start();
require_once './db_utils.php';

$db_utils = new DB_UTILS;
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['maTH'])) {
        $error_message .= "Mã danh mục không được để trống.";
    }
    if (empty($_POST['tenTH'])) {
        $error_message .= "Tên danh mục không được để trống.";
    }
    if($error_message == ""){
          $query_update = "UPDATE thuonghieu set tenTH = ?  where maTH = ?";
          $result_update = $db_utils->execute($query_update,[
            $_POST['tenTH'],
            $_GET['id']
          ]);
          $_SESSION['message'] = "Cập nhật thành công.";
          header('location: thuonghieu.php');
          exit();
    }
}
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(!empty($_GET['id'])){
        $query_get_detail  = "SELECT * FROM thuonghieu WHERE maTH =?";
        $thuonghieu = $db_utils->getOne($query_get_detail,[$_GET['id']]);
if (count($thuonghieu) > 0) { ?>
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
                            <h4>Sửa thương hiệu</h4>
                            <!-- form -->
                            <form method="post" action="">
                                <label class="form-label" for="">Mã thương hiệu: </label>
                                <input value="<?php echo $thuonghieu['maTH'] ?>" class="form-control" type="text" name="maTH" readonly>
                                <label class="form-label" for="">Tên thương hiệu</label>
                                <input value="<?php echo $thuonghieu['tenTH'] ?>" class="form-control" type="text" name="tenTH">
                                <?php
                                if (!empty($error_message)) {
                                    echo "<span class='text-danger'>$error_message</span>";
                                }
                                ?>
                                <button type="submit" class="btn btn-primary mt-2" name="nut">Save</button>
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
