<?php
$mysqli = mysqli_connect('localhost','shop','shop','shop');
if (!$mysqli){
    printf("can't connect to db. EC: %s", mysqli_connect_error());
    exit;
}
else {
    echo 'mysql connected<br>';
}
mysqli_autocommit($mysqli, true);
mysqli_query($mysqli, "SET NAMES 'utf8mb4'");
if (isset($_GET['email'])){
    $sql = "insert into user(`email`, `nickname`, `password`) ";
    $sql .= "values (\"{$_GET['email']}\",\"{$_GET['nickname']}\",\"{$_GET['password']}\")";
    $result = mysqli_query($mysqli, $sql);
    if ($result){
        header("Location: login.php");
        exit;
    }
    else{
        echo("错误描述: " . mysqli_error($mysqli));
    }
}
mysqli_close($mysqli); //optional
?>


<html>
<head>
    <meta charset="UTF-8">
    <title>PHP Store - Register</title>
</head>

<body>
<form action="reg.php">
    Email: <input type="email" name="email"><br>
    Nickname: <input type="text" name="nickname"><br>
    Password: <input type="password" name="password"><br>
    Confirm: <input type="password" name="password1"><br>
    <input type="submit">

</form>
</body>
</html>