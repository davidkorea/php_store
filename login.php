<?php
require_once ('mysql.php');
if (isset($_POST['email'])){
    $sql = "select * from user where email= ?";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt,'s',$_POST['email']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $count = mysqli_stmt_affected_rows($stmt);
    if ($count == 0){
        exit("email:" . $_POST['email'] . " did not register.");
    }
    $row = mysqli_fetch_assoc($result);

    if (password_verify($_POST['password'], $row['password'])){
        $_SESSION['login'] = true;
        $_SESSION['email'] = $row['email'];
        $_SESSION['nickname'] = $row['nickname'];
//        $_SESSION['domain'] = 'localhost';
        header("Location: index.php");
        exit;
    }else{
        exit('Password wrong');
    }
    mysqli_close($mysqli);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script type="text/javascript">
        function validateForm() {
            var email = document.forms["loginForm"]['email'].value;
            if (email == null || email == ""){
                alert('pls input email');
                return false;
            }
            var password = document.forms['loginForm']['password'].value;
            if (password == null || password == ""){
                alert('pls input pw');
                return false;
            }
        }
    </script>
    <meta charset="UTF-8">
    <title>PHP Store - Login</title>
</head>
<body>
<form action="login.php" method="post" name="loginForm" onsubmit="return validateForm();">
    Email: <input type="email" name="email"><br>
    Password: <input type="password" name="password"><br>
    <input type="submit">
</form>
</body>
</html>