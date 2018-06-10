<?php require_once ('mysql.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Store</title>
</head>
<body>
hello,
<?php
if (isset($_SESSION["login"]) && $_SESSION["login"]){
    echo 'Welcome: '. $_SESSION['nickname'] .', ' . $_SESSION['email'];
}

?>
<br>
<a href="reg.php">Register</a>
<a href="login.php">Login</a>
<a href="logout.php">Logout</a>

</body>
</html>