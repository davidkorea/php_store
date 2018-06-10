<?php
require_once('mysql.php');
$err_msg = "";
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (empty($_GET['email']) || empty($_GET['code'])) {
        exit("找回密码错误");
    }

    $sql = "select * from user where email= ? and find_code = ?";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $_GET['email'], $_GET['code']);

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $count = mysqli_stmt_affected_rows($stmt);
    if ($count == 0) {
        exit("找回密码错误");
    }
    $_SESSION['find_email'] = $_GET['email'];
    $_SESSION['find_code'] = $_GET['code'];
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['password'])) {
        $err_msg .= "密码必填<br>";
    }
    if ($_POST['password'] != $_POST['password2']) {
        $err_msg .= "两次密码不一致<br>";
    }
    if (!$_SESSION['find_email'] && !$_SESSION['find_code']) {
        exit("找回密码错误");
    }

    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "update user set `password`=?, find_code='' where email= ?";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $hash, $_SESSION['find_email']);

    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        echo "密码重置成功，请<a href='login.php'>登录</a>";
        unset($_SESSION['find_email']);
        unset($_SESSION['find_code']);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script type="text/javascript">
        function validateForm() {
            var password = document.forms["findForm"]["password"].value;
            if (password == null || password == "") {
                alert("密码必须填写");
                return false;
            }

            var password2 = document.forms["findForm"]["password2"].value;
            if (password != password2) {
                alert("两次输入的密码不一致");
                return false;
            }
        }
    </script>
    <meta charset="UTF-8">
    <title>PHP商城-找回密码</title>
</head>
<body>
<form action="find_password2.php" method="post" name="findForm" onsubmit="return validateForm();">
    密码: <input type="password" name="password"><br>
    确认密码: <input type="password" name="password2"><br>
    <input type="submit" value="提交">
</form>
</body>
</html>
