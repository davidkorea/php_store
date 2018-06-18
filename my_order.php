<?php
require_once('mysql.php');

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
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
    <h5>我的订单</h5>
    <hr/>
    <?php
    $sql = "select i.*,p.name,p.pic_path,p.price*i.quantity as sum from `order_item` i, product p";
    $sql .= " where i.product_id = p.id and order_id=?";
    $stmt_item = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt_item, 'i', $order_id);

    $sql = "select * from `order` where user_id=?";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $_SESSION['id']);

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <tbody>
                <tr style="background-color: #e5e5e5">
                    <td colspan="4">
                        <?php
                        echo $row['create_time'];
                        echo '<span class="ml-5">订单号: ' . $row['id'] . "</span>";
                        echo '<span class="ml-5">订单金额: ' . $row['price'] . '</span>';
                        ?>
                    </td>
                </tr>
                <?php
                $order_id = $row['id'];
                mysqli_stmt_execute($stmt_item);
                $result_item = mysqli_stmt_get_result($stmt_item);
                while ($row_item = mysqli_fetch_assoc($result_item)) {
                    echo "<tr>";
                    echo "<td><a href='detail.php?id={$row_item['product_id']}' target='_blank'>";
                    echo "<img src='{$IMAGE_URL_PREFIX}{$row_item['pic_path']}' style='width: 50px;'></a> </td>";
                    echo "<td>{$row_item['name']}</td>";
                    echo "<td>x{$row_item['quantity']}</td>";
                    echo "<td>{$row_item['sum']}</td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
        <?php
    }
    require_once 'footer.php';
    ?>
</body>
</html>
