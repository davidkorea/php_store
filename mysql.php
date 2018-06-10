<?php
session_start();
$mysqli = mysqli_connect('localhost','shop','shop','shop');
if (!$mysqli){
    printf("can't connect to db. EC: %s", mysqli_connect_error());
    exit;
}
//else {
//    echo 'mysql connected<br>';
//}
mysqli_autocommit($mysqli, true);
mysqli_query($mysqli, "SET NAMES 'utf8mb4'");