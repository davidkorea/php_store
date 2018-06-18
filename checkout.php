<?php
require_once('mysql.php');

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
}
$cart = $_SESSION['cart'];
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
    <form method="post" action="order.php">
        <div class="form-group row">
            <label for="address" class="col-sm-2 col-form-label">送货地址</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="address" name="address" required="required">
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th></th>
                    <th>商品</th>
                    <th>单价</th>
                    <th>数量</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $sql = "select * from product where id=?";
                $stmt = mysqli_prepare($mysqli, $sql);
                mysqli_stmt_bind_param($stmt, 'i', $id);

                $total_amount = 0;
                foreach ($cart as $id => $count) {
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $row = mysqli_fetch_assoc($result);
                    $total_amount += $row['price'] * $count;
                    echo "<tr id='tr_{$id}'>";
                    echo "<td><img src='{$IMAGE_URL_PREFIX}{$row['pic_path']}' style='width: 100px;'></td>";
                    echo "<td>{$row['name']}</td>";
                    echo "<td>{$row['price']}</td>";
                    echo "<td>{$count}</td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="offset-8 col-2">
                <span style="font-size: smaller;color: gray;">总价: </span>
                <span style="color: red;font-size: larger">¥
                <span id="total_sum">
                <?php echo number_format($total_amount, 2, ".", ""); ?>
                </span>
            </span>
            </div>
            <div class="col-2">
                <button class="btn btn-danger" id="btn_order">提交订单</button>
            </div>
        </div>
    </form>
    <?php require_once 'footer.php'; ?>
</body>
</html>
