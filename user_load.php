<?php
require_once 'mysql.php';
$sql = "select * from user where id=?";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, 'i', $_GET['id']);

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

echo json_encode($row);

