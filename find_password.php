<?php
require_once('mysql.php');
$err_msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['email'])) {
        $err_msg .= "邮箱必填<br>";
    }
    $sql = "select * from user where email= ?";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, 's', $_POST['email']);

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $count = mysqli_stmt_affected_rows($stmt);
    if ($count == 0) {
        exit("邮箱" . $_POST['email'] . "并没有注册");
    }

    $code = md5(uniqid(microtime(true), true));
    $link = "http://localhost/php_lesson/12/find_password2.php?email=" . $_POST['email'];
    $link .= "&code=" . $code;

    $subject = "PHP商城-找回密码";
    $subject = "=?UTF-8?B?" . base64_encode($subject) . "?=";
    $message = "<html><head><title>PHP商城-找回密码</title></head>";
    $message .= "<body><a href='" . $link . "' target='_blank'>重置密码</a></body>";
    $message .= "</html>";

    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
    $headers .= "Content-Transfer-Encoding: 8bit\r\n";
    $headers .= "From: admin@localhost\r\n";

    mail($_POST['email'], $subject, $message, $headers);

    $sql = "update user set find_code=? where email = ?";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $code, $_POST['email']);
    mysqli_stmt_execute($stmt);

    exit("邮件已经发送，请按照邮件提示进行操作");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script type="text/javascript">
        function validateForm() {
            var email = document.forms["findForm"]["email"].value;
            if (email == null || email == "") {
                alert("邮箱必须填写");
                return false;
            }
        }
    </script>
    <meta charset="UTF-8">
    <title>PHP商城-找回密码</title>
</head>
<body>
<form action="find_password.php" method="post" name="findForm" onsubmit="return validateForm();">
    邮箱: <input type="email" name="email"><br>
    <?php echo $err_msg; ?>
    <input type="submit" value="下一步">
</form>
</body>
</html>
