<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Store</title>
</head>
<body>
hello,
<?php
if ($_COOKIE["login"] && $_COOKIE["login"] == "1"){
    echo 'Welcome: '. $_COOKIE['email'];
}

?>
<br>
<a href="reg.php">Register</a>

</body>
</html>