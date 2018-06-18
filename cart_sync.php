<?php
session_start();
$ids = $_POST['ids'];
$counts = $_POST['counts'];
$cart = [];
foreach ($ids as $index => $id) {
    $cart[$id] = $counts[$index];
}
$_SESSION['cart'] = $cart;

