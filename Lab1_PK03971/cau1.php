<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(!empty($_POST['number']) || isset($_POST['number'])){
        $number = $_POST['number'];
        if($number <0){
            echo "Số bạn vừa nhập là số âm.";
        }else if($number>0){
            echo "Số bạn vừa nhập là số dương.";
        }else{
            echo "Số bạn vừa nhập là số 0.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <label for="">Xin mời nhập vào 1 số nguyên</label>
        <input type="number" name="number">
    </form>
</body>
</html>