<?php
require_once('mysql.php');

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
}
$cart = $_SESSION['cart'];

$sql = "select * from product where id=?";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, 'i', $id);

$total_amount = 0;
foreach ($cart as $id => $count) {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $total_amount += $row['price'] * $count;
}

$sql = "insert into `order` (user_id,price,address) values (?,?,?)";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, 'ids', $_SESSION['id'],
    $total_amount, $_POST['address']);
mysqli_stmt_execute($stmt);
$order_id = mysqli_insert_id($mysqli);


$sql = "insert into order_item (order_id,product_id,quantity) values (?,?,?)";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, 'iii', $order_id, $id, $count);
foreach ($cart as $id => $count) {
    mysqli_stmt_execute($stmt);
}

unset($_SESSION['cart']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css?9">
    <title>PHP商城</title>
</head>
<body>
<?php require_once 'navbar.php'; ?>

<div class="container">
    订单已经生成，请支付！
    <?php require_once 'footer.php'; ?>
</body>
</html>
