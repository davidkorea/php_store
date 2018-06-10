<?php
$mysqli = mysqli_connect('localhost', 'shop', 'shop', 'shop');
mysqli_autocommit($mysqli, true);
mysqli_query($mysqli, "SET NAMES 'utf8mb4'");
if (isset($_POST['email'])){
    $sql = "select * from user where email=";
    $sql .= "'" . $_POST['email'] . "'";
    $result = mysqli_query($mysqli, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($_POST['password'] == $row['password']){
        setcookie("login","1");
        setcookie("email",$row['email']);
        setcookie("nickname",$row['nickname']);
        header("Location: index.php");
        exit;
    }else{
        echo "Password wrong";
        exit;
    }
    mysqli_close($mysqli);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Store - Login</title>
</head>
<body>
<form action="login.php" method="post">
    Email: <input type="email" name="email"><br>
    Password: <input type="password" name="password"><br>
    <input type="submit">
</form>
</body>
</html>