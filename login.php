<?php
require_once('mysql.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "select * from user where email= ?";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, 's', $_POST['email']);

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $count = mysqli_stmt_affected_rows($stmt);
    if ($count == 0) {
        exit("邮箱" . $_POST['email'] . "并没有注册");
    }
    $row = mysqli_fetch_assoc($result);

    if (password_verify($_POST['password'], $row['password'])) {
        $_SESSION['login'] = true;
        $_SESSION['id'] = $row['id'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['nickname'] = $row['nickname'];

        $back_url = "index.php";
        if (isset($_SESSION['back_url'])) {
            $back_url = $_SESSION['back_url'];
            unset($_SESSION['back_url']);
        } else if (isset($_SERVER["HTTP_REFERER"]) && !substr($_SERVER["HTTP_REFERER"], -9) == "login.php") {
            $back_url = $_SERVER["HTTP_REFERER"];
        }

        header("Location: {$back_url}");
        exit;
    } else {
        exit('密码错误');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script type="text/javascript">
        function validateForm() {
            var email = document.forms["loginForm"]["email"].value;
            if (email == null || email == "") {
                alert("邮箱必须填写");
                return false;
            }

            var password = document.forms["loginForm"]["password"].value;
            if (password == null || password == "") {
                alert("密码必须填写");
                return false;
            }
        }
    </script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>PHP商城-登录</title>
</head>
<body class="text-center">
<form action="login.php" method="post" id="loginForm" name="loginForm" class="form" onsubmit="return validateForm();">
    <h1 class="h3 mb-3">请登录</h1>
    <label for="inputEmail" class="sr-only">邮箱</label>
    <input type="email" name="email" id="inputEmail" class="form-control" placeholder="邮箱" required autofocus>
    <label for="inputPassword" class="sr-only">密码</label>
    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="密码" required>
    <button class="btn btn-lg btn-primary btn-block" type="submit">登录</button>
    <a href="reg.php" class="float-right">免费注册</a>
    <a href="find_password.php" class="float-right">忘记密码</a>
    <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
</form>
</body>
</html>
