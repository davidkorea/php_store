<?php
require_once('mysql.php');

if (isset($_SESSION['login'])) {
    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    if (isset($_COOKIE['cart'])) {
        $cookie_cart = unserialize($_COOKIE['cart']);
        foreach ($cookie_cart as $id => $count) {
            $exist_count = array_key_exists($id, $cart) ? $cart[$id] : 0;
            $cart[$id] = $exist_count + $count;
        }
        $_SESSION['cart'] = $cart;
        unset($_COOKIE['cart']);
        setcookie('cart', null, time() - 3600);
    }
} else {
    $cart = isset($_COOKIE['cart']) ? unserialize($_COOKIE['cart']) : [];
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
    <?php if (!isset($_SESSION['login'])) { ?>
        <div class="row">
            <div class="alert alert-warning w-100" role="alert">
                您还没有登录！登录后购物车的商品将保存到您账号中 <a href="login.php" class="btn btn-danger btn-sm">立即登录</a>
            </div>
        </div>
    <?php } ?>

    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
            <tr>
                <th></th>
                <th>商品</th>
                <th>单价</th>
                <th>数量</th>
                <th>小计</th>
                <th>操作</th>
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
                echo "<td><input type='number' value='{$count}' data-id='{$id}' style='width: 50px;'/></td>";
                echo "<td class='sub_sum' data-price='{$row['price']}'>"
                    . number_format($row['price'] * $count, 2, ".", "")
                    . "</td>";
                echo "<td><button class='delete_item' data-id='{$id}'>删除</button></td>";
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
            <button class="btn btn-danger" id="btn_checkout">去结算</button>
        </div>
    </div>
    <?php require_once 'footer.php'; ?>
    <script>
        $('input[type=number]').on('change', function () {
            var count = $(this).val();
            var $sub_sum = $(this).parent().next();
            var price = $sub_sum.data('price');
            $sub_sum.text((count * price).toFixed(2));

            var total_sum = 0;
            $('td.sub_sum').each(function () {
                total_sum += parseFloat($(this).text());
            });
            $('#total_sum').text(total_sum.toFixed(2));
        });

        $('button.delete_item').on('click', function () {
            var r = confirm("确认要删除?");
            if (r === true) {
                var id = $(this).data('id');
                $('#tr_' + id).remove();
            }
        });

        function cart_sync() {
            var ids = [];
            var counts = [];
            $('input[type=number]').each(function () {
                var id = $(this).data('id');
                var count = $(this).val();
                ids.push(id);
                counts.push(count);
            });
            $.ajax({
                url: 'cart_sync.php',
                method: 'post',
                data: {
                    ids: ids,
                    counts: counts
                }
            }).done(function () {
                location.href = 'checkout.php';
            });
        }

        $('#btn_checkout').click(function () {
            <?php
            if (isset($_SESSION['login'])) {
                echo "cart_sync();";
            } else {
                $_SESSION['back_url'] = 'cart.php';
                echo "location.href='login.php';";
            }
            ?>
        });
    </script>
</body>
</html>
