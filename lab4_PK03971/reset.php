<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Reset Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Roboto&display=swap" rel="stylesheet" />
  <link href="shared.css" rel="stylesheet" />
</head>

<body>
  <?php
  require_once './db_utils.php';
  $db_util = new DB_UTILS();
  $error = "";
  $id = $_GET['id'];
  var_dump($_GET['id']);
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['password'])) {
      $error = "Password không được để trống";
    }
    if ($error == "") {
      $check_email = "SELECT * FROM khachhang WHERE email = ?";
      $user = $db_util->getOne($check_email, [$_GET['id']]);

      if (!$user) {
        $error = "Email không tồn tại, vui lòng kiểm tra lại.";
      } else {
        $query_reset = "UPDATE khachhang SET password = ? WHERE email = ? ";
        $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $result_reset = $db_util->execute($query_reset, [$password_hash, $_GET['id']]);
        if ($result_reset) {
          echo "✅ Mật khẩu đã cập nhật thành công!";
          header("location: login.php");
          exit();
        } else {
          echo "❌ Có lỗi xảy ra khi cập nhật mật khẩu.";
        }
      }
    }
  }
  ?>
  <div class="auth-container">
    <h2>Reset Your Password</h2>
    <form id="resetForm" action="" method="post">
      <div class="mb-3">
        <label>New Password</label>
        <input type="password" name="password" class="form-control" required />
      </div>
      <div class="d-grid">
        <button class="btn btn-primary">Reset Password</button>
      </div>
    </form>
  </div>
</body>

</html>