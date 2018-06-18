<?php
require_once('mysql.php');

$err_msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['email'])) {
        $err_msg .= "邮箱必填<br>";
    }
    if (empty($_POST['nickname'])) {
        $err_msg .= "昵称必填<br>";
    }
    if (empty($_POST['password'])) {
        $err_msg .= "密码必填<br>";
    }
    if ($_POST['password'] != $_POST['password2']) {
        $err_msg .= "两次密码不一致<br>";
    }

    $email = $_POST['email'];
    $nickname = $_POST['nickname'];
    $password = $_POST['password'];
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "insert into user(`email`, `nickname`, `password`) values (?,?,?)";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, 'sss', $email, $nickname, $hash);

    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        header("Location: login.php");
        exit;
    } else if (mysqli_stmt_errno($stmt) == 1062) {
        $err_msg .= "邮箱" . $email . "已经存在";
    } else {
        $err_msg .= "数据库操作失败<br>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script type="text/javascript">
        function validateForm() {
            var email = document.forms["regForm"]["email"].value;
            if (email == null || email == "") {
                alert("邮箱必须填写");
                return false;
            }

            var nickname = document.forms["regForm"]["nickname"].value;
            if (nickname == null || nickname == "") {
                alert("昵称必须填写");
                return false;
            }

            var password = document.forms["regForm"]["password"].value;
            if (password == null || password == "") {
                alert("密码必须填写");
                return false;
            }

            var password2 = document.forms["regForm"]["password2"].value;
            if (password != password2) {
                alert("两次输入的密码不一致");
                return false;
            }
        }
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>PHP商城-注册</title>
</head>
<body class="text-center">
<form action="reg.php" method="post" id="regForm" name="regForm" class="form" onsubmit="return validateForm();">
    <h1 class="h3 mb-3">请注册</h1>
    <label for="inputEmail" class="sr-only">邮箱</label>
    <input type="email" name="email" id="inputEmail" class="form-control" placeholder="邮箱" required autofocus>
    <label for="nickname" class="sr-only">昵称</label>
    <input type="text" name="nickname" id="nickname" class="form-control" placeholder="昵称" required>

    <label for="password" class="sr-only">密码</label>
    <input type="password" name="password" id="password" class="form-control" placeholder="密码" required>
    <label for="password2" class="sr-only">确认密码</label>
    <input type="password" name="password2" id="password2" class="form-control" placeholder="确认密码" required>

    <?php echo $err_msg; ?>
    <button class="btn btn-lg btn-primary btn-block" type="submit">注册</button>
    <a href="login.php" class="float-right">已有账号登录</a>
    <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
</form>
</body>
</html>
