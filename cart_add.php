<?php
require_once('mysql.php');
$id = $_GET['id'];
$count = isset($_GET['count']) ? $_GET['count'] : 1;

if (isset($_SESSION['login'])) {
    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    if (array_key_exists($id, $cart)) {
        $cart[$id] += $count;
    } else {
        $cart[$id] = $count;
    }
    $_SESSION['cart'] = $cart;
} else {
    $cart = isset($_COOKIE['cart']) ? unserialize($_COOKIE['cart']) : [];
    if (array_key_exists($id, $cart)) {
        $cart[$id] += $count;
    } else {
        $cart[$id] = $count;
    }
    setcookie('cart', serialize($cart), time() + (10 * 365 * 24 * 60 * 60));
}
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
    <div class="row" style="margin-bottom: 30px;">
        <div class="text-success">
            <span data-feather="check-circle"></span> 商品已成功加入购物车！
        </div>
    </div>
    <div class="row">
        <?php
        $sql = "select * from product where id=?";
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, 'i', $_GET['id']);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $id = $row['id'];
        $pic_path = $row['pic_path'];
        $name = $row['name'];
        $price = $row['price'];
        echo "<div class='col-8'>";
        echo "<a href='detail.php?id={$id}'>";
        echo "<img  style='width: 100px; float: left' src='{$IMAGE_URL_PREFIX}{$pic_path}'>";
        echo "</a>";
        echo "<a href='detail.php?id={$id}'>";
        echo "{$name}</a>";
        echo "<div class='text-muted text-right' style='font-size: small'>数量:1</div>";
        echo "</div>";
        ?>
        <div class="offset-2 col-2 align-self-end"><a href="cart.php" class="btn btn-danger">去购物车结算 ></a></div>
    </div>
</div>
<?php require_once 'footer.php'; ?>

</body>
</html>
