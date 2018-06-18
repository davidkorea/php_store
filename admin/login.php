<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['name'] == 'admin' && $_POST['password'] == 'admin') {
        $_SESSION['admin_login'] = "1";
        header("Location: index.php");
        exit;
    } else {
        exit('管理员用户名/密码错误');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <title>PHP商城-管理后台=登录</title>
</head>
<body class="text-center">
<form action="login.php" method="post" id="loginForm" name="loginForm" class="form" onsubmit="return validateForm();">
    <h1 class="h3 mb-3">管理员登录</h1>
    <label for="name" class="sr-only">管理员</label>
    <input type="text" name="name" id="name" class="form-control" required autofocus placeholder="管理员">
    <label for="inputPassword" class="sr-only">密码</label>
    <input type="password" name="password" id="inputPassword" class="form-control" required placeholder="密码">
    <button class="btn btn-lg btn-primary btn-block" type="submit">登录</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
</form>
</body>
</html>
