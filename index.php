<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Store</title>
</head>
<body>
hello,
<?php
if ($_SESSION["login"] && $_SESSION["login"]){
    echo 'Welcome: '. $_SESSION['email'];
}

?>
<br>
<a href="reg.php">Register</a>
<a href="login.php">Login</a>

</body>
</html>