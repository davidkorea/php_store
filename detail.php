<?php
require_once('mysql.php');

$sql = "select * from product where id=?";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, 'i', $_GET['id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);
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

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <?php
        $cat1 = substr($product['cat'], 0, 2);
        $cat2 = substr($product['cat'], 0, 4);
        $cat3 = $product['cat'];
        $sql = "select * from category where code in (?,?,?) order by code";
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, 'sss', $cat1, $cat2, $cat3);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<li class='breadcrumb-item'><a href='list.php?cat=${row['code']}'>";
            echo "{$row['name']}</a></li>";
        }
        ?>
    </ol>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-4">
            <figure class="figure">
                <img src="<?php echo $IMAGE_URL_PREFIX . $product['pic_path'] ?>"
                     class="figure-img img-fluid rounded">
            </figure>
        </div>
        <div class="col-8">
            <div><?php echo $product['name'] ?></div>
            <div>价格：
                <span style="color: red; font-size: larger">
                            ￥<?php echo $product['price'] ?>
                        </span>
            </div>
            <div style="margin-top: 230px;">
                <form action="cart_add.php">
                    <input type="number" name="count" value="1" style="width: 50px;"/>
                    <input type="hidden" name="id" value="<?php echo $product['id'] ?>"/>
                    <button class="btn btn-danger">加入购物车</button>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-10">
            <?php echo nl2br($product['description']); ?>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>

</body>
</html>
