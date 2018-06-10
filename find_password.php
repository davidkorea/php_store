<?php
require_once ('mysql.php');
$err_msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (empty($_POST['email'])){
        $err_msg .= "pls input email<br>";
    }

    $sql = "select * from user where email = ?";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, 's', $_POST['email']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $count = mysqli_stmt_affected_rows($stmt);
    if ($count == 0){
        exit("email: " . $_POST['email'] . " does not exsit" );
    }

    $code = md5(uniqid(microtime(true), true));
    $link = "https://localhost:4433/php_store/find_password2.php?email=".$_POST['email'];
    $link .= "&code=".$code;

    $subject = "PHP Store - Find Password";
    $subject = "=?UTF-8?B?" . base64_encode($subject) . "?=";
    $message = "<html><head><title>PHP Store - Find Password</title>></head>";
    $message .= "<body><a href=' " . $link . " ' target='_blank'>Reset Password</a></body>";
    $message .= "</html>";

    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
    $headers .= "Content-Transfer-Encoding: 8bit\r\n";
    $headers .= "From: admin@localhost\r\n";

    mail($_POST['email'], $subject,$message,$headers);

    $sql = "update user set find_code=? where email=?";
    $stmt = mysqli_prepare($mysqli,$sql);
    mysqli_stmt_bind_param($stmt, 'ss',$code,$_POST['email']);
    mysqli_stmt_execute($stmt);

    exit("mail has been sent, pls follow the guidelines in email");
}
?>

<html lang="en">
<head>
    <script type="text/javascript">
        function validateForm() {
            var email = document.forms["findForm"]["email"].value;
            if (email == null || email == ""){
                alert("pls input email");
                return false;
            }
        }
    </script>
    <meta charset="UTF-8">
    <title>PHP Store - Find Password</title>
</head>
<body>
<form action="find_password.php" method="post" name="findForm" onsubmit="return validateForm();">
    Email: <input type="email", name="email"><br>
    <input type="submit" value="Next">
</form>
</body>
</html>