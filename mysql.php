<?php
session_start();
$mysqli = mysqli_connect('localhost','shop','shop','shop');
if (!$mysqli){
    printf("can't connect to db. EC: %s", mysqli_connect_error());
    exit;
}
mysqli_autocommit($mysqli, true);
mysqli_query($mysqli, "SET NAMES 'utf8mb4'");

$IMAGE_URL_PREFIX = "/php_store/upload/"; //show on url
$UPLOAD_DIR = "C:/xampp/htdocs/php_store/upload/"; //real file path
$time_dir = date("Y-m-d") . "/"; // everyday has one sub folder
if (!file_exists($UPLOAD_DIR . $time_dir)) {
    mkdir($UPLOAD_DIR . $time_dir, 0777, true);
}
// 0777 for read/write permission for linus or mac,
// recursive: for any subpath in real path, if not exists, then create it

function show_product_publish_status($status)
{
    return $status == 1 ? '已上架' : '未上架';
}

function show_order_status($status)
{
    $msg = '';
    switch ($status) {
        case 0:
            $msg = '未支付';
            break;
        case 1:
            $msg = '已取消';
            break;
        case 2:
            $msg = '已支付';
            break;
        case 3:
            $msg = '已审核';
            break;
        case 4:
            $msg = '已发货';
            break;
        case 5:
            $msg = '已完成';
            break;
        case 10:
            $msg = '已取消';
            break;
        default:
            break;
    }
    return $msg;
}