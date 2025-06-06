<!DOCTYPE html>
<html lang="en">

<head>
    <title>php 1 co ban</title>
    <style>
        label,
        textarea,
        button {
            display: block;
            margin-top: 5px;
        }

        label {
            font-weight: bold;
        }

        .xanh {
            color: green;
        }

        .do {
            color: red;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

    <head>

    <body>
        <form action="" method="POST">
            <label class="form-label">Ds Sinh viên</label>
            <textarea class="form-control" rows="4" name="ds" placeholder="nhập danh sách"></textarea>
            <button class="btn btn-primary mt-2" type="submit" name="action" value="bai2">Kết quả</button>
        </form>
    </body>

</html>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ds_sv = trim($_POST['ds']);
    $arr_sv = explode("\n", $ds_sv);
    // print_r($arr_sv);
    /**
     * in ra chan xanh color
     * in le do color
     * dem so luong sv nhap vao
     */
    for ($i = 0; $i < count($arr_sv); $i++) {
        if ($i % 2 == 0) {
            echo "<p class='xanh'>$arr_sv[$i]</p><br>";
        } else {
            echo "<p class='do'>$arr_sv[$i]</p><br>";
        }
    }
} ?>