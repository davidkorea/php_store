<?php
require_once ('mysql.php');

$err_msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (empty($_POST['email'])){
        $err_msg .= "pls input email<br>";
    }
    if (empty($_POST['nickname'])){
        $err_msg .= "pls input nickname<br>";
    }
    if (empty($_POST['password'])){
        $err_msg .= "pls input pw";
    }
    if ($_POST['password'] != $_POST['password1']){
        $err_msg .= 'pls input same pw';
    }

    $email = $_POST['email'];
    $nickname = $_POST['nickname'];
    $password = $_POST['password'];
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "insert into user(`email`,`nickname`,`password`) values (?,?,?)";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, 'sss',$email,$nickname, $hash);
    $result = mysqli_stmt_execute($stmt);
//    $result = mysqli_query($mysqli, $sql);
    if ($result){
        header("Location: login.php");
        exit;
    }
    else{
//        echo("错误描述: " . mysqli_error($mysqli));
        $err_msg .=  "数据库操作失败<br>";
    }
}
//if (isset($_POST['email'])){}
?>


<html>
<head>
    <script type="text/javascript">
        function validateForm() {
            var email = document.forms["regForm"]["email"].value;
            if (email == null || email == ""){
                alert("pls input email");
                return false;
            }

            var nickname = document.forms["regForm"]["nickname"].value;
            if (nickname == null || nickname == ""){
                alert('pls input nickname');
                return false;
            }

            var password = document.forms["regForm"]["password"].value;
            if (password == null || password == ""){
                alert('pls input pw');
                return false;
            }
            var password1 = document.forms["regForm"]["password1"].value;
            if (password != password1){
                alert('pls input same pw');
                return false;
            }
        }
    </script>
    <meta charset="UTF-8">
    <title>PHP Store - Register</title>
</head>

<body>
<form action="reg.php" method="post", name="regForm", onsubmit="return validateForm();">
    Email: <input type="email" name="email"><br>
    Nickname: <input type="text" name="nickname"><br>
    Password: <input type="password" name="password"><br>
    Confirm: <input type="password" name="password1"><br>
    <?php echo $err_msg; ?>
    <input type="submit">
</form>
</body>
</html>