<?php
require_once 'mysql.php';
$sql = "update user set email=?,nickname=? where id=?";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, 'ssi', $_POST['email'], $_POST['nickname'], $_POST['id']);

$result = mysqli_stmt_execute($stmt);
if ($result) {
    $json = array("success" => true);
    echo json_encode($json);
}

