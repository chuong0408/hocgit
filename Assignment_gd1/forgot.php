<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Roboto&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: #fff;
            color: #333;
        }

        .auth-container {
            max-width: 420px;
            margin: 6rem auto;
            padding: 2rem;
            border-radius: 16px;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        h2 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            text-align: center;
            margin-bottom: 1.5rem;
            color: #d63384;
        }

        .btn-primary {
            background-color: #d63384;
            border: none;
        }

        .btn-primary:hover {
            background-color: #c22575;
        }

        .form-control {
            border-radius: 10px;
        }

        .form-text a {
            color: #d63384;
            text-decoration: none;
        }

        .form-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <?php
    $error = "";
    require_once "./MailService.php";
    require_once "./db_utils.php";
    require_once "./utils.php";

    $db_util = new DB_UTILS();

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        if (empty($_POST['email'])) {
            $error .= "email ko được trống";
        }
        if ($error == "") {
            $check_email = "select * From khachhang where email = ?";
            $result = $db_util->getOne($check_email, [$_POST['email']]);
            if ($result) {
                /**
                 * tao otp
                 */
                $otp = getRandomOTP(6);
                $password_new = getRandom(10);
                $email = $_POST['email'];
                $link = "http://localhost/php1/lab4/submit_otp.php";
                $subject = "lấy lại mật khẩu";
                $body = "mã OTP: $otp  email $_POST[email] link: $link ";
                MailService::send($email,USERNAME_EMAIL, $subject, $body);
                $query_otp = "UPDATE khachhang SET OTP =?,OTP_time = NOW() + INTERVAL 10 MINUTE  WHERE email =?";
                $result_otp = $db_util->execute($query_otp,[$otp,$_POST['email']]);
            } else {
                $error .= "Email không tồn tại";
            }
        }
    }

    ?>
    <div class="auth-container">
        <h2>Forgot Your Password?</h2>
        <form id="forgotForm" method="POST" action="">
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required />
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Send Reset Link</button>
            </div>
            <div class="form-text text-center mt-3">
                <a href="login.html">Back to Login</a>
            </div>
        </form>
    </div>
</body>

</html>