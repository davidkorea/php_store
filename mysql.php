<?php
session_start();
$mysqli = mysqli_connect('localhost','shop','shop','shop');
if (!$mysqli){
    printf("can't connect to db. EC: %s", mysqli_connect_error());
    exit;
}

mysqli_autocommit($mysqli, true);
mysqli_query($mysqli, "SET NAMES 'utf8mb4'");

function show_product_publish_status($status)
{
    return $status == 1 ? '已上架' : '未上架';
}