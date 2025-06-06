<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Roboto&display=swap" rel="stylesheet" />
    <link href="shared.css" rel="stylesheet" />
</head>

<body>
    <?php
    require "./db_utils.php";
    session_start();
    $db_util = new DB_UTILS();
    $error = "";
    if (
        $_SERVER['REQUEST_METHOD'] == "POST"
    ) {
        if (empty($_POST['email']) || empty($_POST['password'])) {
            $error .= "Email và mật khẩu không được để trống.";
        }

        if ($error == "") {
            // b1
            $check_email = "SELECT * FROM khachhang WHERE email = ?";
            $result = $db_util->getOne($check_email, [$_POST['email']]);
            if ($result) {
                //b2
                //kiem tra khop tai khoan or mat khau
                $kt_matkhau = password_verify($_POST['password'], $result['password']);
                if ($kt_matkhau) {
                    $_SESSION['user_id'] = $result['makh'];
                    $_SESSION['name'] = $result['tenkh'];
                    $_SESSION['role'] = $result['role'];
                    header('location: home.php');
                    exit();
                } else {
                    $error .= "email or password wrong";
                }
            } else {
                $error .= "Email hoặc mật khẩu không đúng.";
            }
        }
    }
    ?>
    <div class="auth-container">
        <h2>PHP EASY GO</h2>
        <form id="loginForm" method="post" action="">
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required />
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required />
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
            <?php if ($error !== "") {
                echo "<span class='text-danger'>$error</span>";
            } ?>
            <div class="form-text text-center mt-3">
                <a href="forgot.php">Forgot password?</a> · <a href="register.php">Sign up</a>
            </div>
        </form>
    </div>
</body>

</html>