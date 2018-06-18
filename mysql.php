<?php
session_start();
$mysqli = mysqli_connect('localhost', 'shop', 'shop', 'shop');
mysqli_autocommit($mysqli, true);
mysqli_query($mysqli, "SET NAMES 'utf8mb4'");

$IMAGE_URL_PREFIX = "/php_store/upload/";
