<?php
require_once ('mysql.php');
if ($_GET['status'] == 1){
    $sql = "update product set publish_status=?, publish_time=now() where id=?";
} else{
    $sql = "update product set publish_status=?, publish_time=NULL where id=?";
}
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt,'ii',$_GET['status'],$_GET['id']);
$result = mysqli_stmt_execute($stmt);
if ($result){
    echo "success";
}