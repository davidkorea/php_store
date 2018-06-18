<?php
require_once 'mysql.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>PHP商城-管理后台</title>
    <?php require_once 'header.php'; ?>
</head>

<body>
<?php require_once 'navbar.php'; ?>
<div class="container-fluid">
    <div class="row">
        <?php require_once 'sidebar.php' ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <h6>订单明细</h6>
            <hr>
            <?php
            $sql = "select o.*,u.nickname as nickname from `order` o, user u WHERE o.user_id=u.id and o.id=?";
            $stmt = mysqli_prepare($mysqli, $sql);
            mysqli_stmt_bind_param($stmt, 'i', $_GET['id']);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            ?>
            <div class="container">
                <div class="row">
                    <div class="col-sm-2">订单编号：</div>
                    <div class="col-sm-4"><?php echo $row['id'] ?></div>
                </div>
                <div class="row">
                    <div class="col-sm-2">用户：</div>
                    <div class="col-sm-4"><?php echo $row['nickname'] ?></div>
                </div>
                <div class="row">
                    <div class="col-sm-2">总价：</div>
                    <div class="col-sm-4"><?php echo $row['price'] ?></div>
                </div>
                <div class="row">
                    <div class="col-sm-2">创建时间：</div>
                    <div class="col-sm-4"><?php echo $row['create_time'] ?></div>
                </div>
                <div class="row">
                    <div class="col-sm-2">状态：</div>
                    <div class="col-sm-4"><?php echo show_order_status($row['status']) ?></div>
                </div>
                <div class="row">
                    <div class="col-sm-2">发货地址：</div>
                    <div class="col-sm-4"><?php echo $row['address'] ?></div>
                </div>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th>订单项列表</th>
                        <th>单价</th>
                        <th>数量</th>
                        <th>总价</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql = "select i.*,p.* from `order_item` i, product p WHERE i.product_id = p.id and i.order_id=?";
                    $stmt = mysqli_prepare($mysqli, $sql);
                    mysqli_stmt_bind_param($stmt, 'i', $_GET['id']);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$row['name']}</td>";
                        echo "<td>{$row['price']}</td>";
                        echo "<td>{$row['quantity']}</td>";
                        echo "<td>" . ($row['price'] * $row['quantity']) . "</td>";
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>
<?php require_once 'footer.php'; ?>
</body>
</html>
