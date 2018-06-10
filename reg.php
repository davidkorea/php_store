<?php
require_once ('mysql.php');
if (isset($_POST['email'])){
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
        echo("错误描述: " . mysqli_error($mysqli));
    }
}
mysqli_close($mysqli); //optional
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
    <input type="submit">

</form>
</body>
</html>