<?php
require_once('mysql.php');
$count_per_page = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $count_per_page;

$total_pages_sql = "SELECT COUNT(*) FROM `product`";
$result = mysqli_query($mysqli, $total_pages_sql);
$total_rows = mysqli_fetch_array($result)[0];
$total_pages = ceil($total_rows / $count_per_page);
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
        for ($i = 2; $i <= strlen($_GET['cat']); $i += 2) {
            $cat = substr($_GET['cat'], 0, $i);
            $sql = "select * from category where code=?";
            $stmt = mysqli_prepare($mysqli, $sql);
            mysqli_stmt_bind_param($stmt, 'i', $cat);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            if ($cat == $_GET['cat']) {
                echo "<li class='breadcrumb-item active' aria-current='page'>";
                echo "{$row['name']}</li>";
            } else {
                echo "<li class='breadcrumb-item'><a href='?cat=${row['code']}'>";
                echo "{$row['name']}</a></li>";
            }
        }
        ?>
    </ol>
</nav>

<div class="container-fluid">
    <div class="row">
        <main role="main" class="container">
            <div class="row">
                <?php
                $sql = "select * from product where cat LIKE ? order by id desc LIMIT ?,? ";
                $stmt = mysqli_prepare($mysqli, $sql);
                $like = $_GET['cat'] . '%';
                mysqli_stmt_bind_param($stmt, 'sii', $like, $offset, $count_per_page);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id'];
                    $pic_path = $row['pic_path'];
                    $name = $row['name'];
                    $price = $row['price'];
                    ?>
                    <div class="col-md-3">
                        <div class="card mb-3 box-shadow">
                            <a href="detail.php?id=<?php echo $id ?>" target="_blank">
                                <img class="card-img-top"
                                     src="<?php echo $IMAGE_URL_PREFIX . $pic_path ?>"
                                     alt="Card image cap">
                            </a>
                            <div class="card-body">
                                <p class="card-title" style="color:red;">¥<?php echo $price ?></p>
                                <p class="card-text"><?php echo $name ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-outline-danger"
                                           href="cart_add.php?id=<?php echo $id ?>">加入购物车</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </main>
    </div>
    <ul class="pagination justify-content-center">
        <li class="page-item">
            <a class="page-link" href="?page=1&cat=<?php echo $_GET['cat']; ?>">首页</a>
        </li>
        <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
            <a class="page-link"
               href="<?php echo $page <= 1 ? '#' : "?page=" . ($page - 1) . "&cat=" . $_GET['cat']; ?>">上页</a>
        </li>
        <li class="page-item disabled">
            <a class="page-link"><?php echo '第' . $page . '/' . $total_pages . '页'; ?></a>
        </li>
        <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
            <a class="page-link"
               href="<?php echo $page >= $total_pages ? '' : "?page=" . ($page + 1) . "&cat=" . $_GET['cat']; ?>">下页</a>
        </li>
        <li class="page-item">
            <a class="page-link" href="?page=<?php echo $total_pages . "&cat=" . $_GET['cat']; ?>">末页</a>
        </li>
    </ul>

</div>

<?php require_once 'footer.php'; ?>

</body>
</html>
