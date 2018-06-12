<?php
require_once 'mysql.php';
$count_per_page = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $count_per_page;

$total_pages_sql = "SELECT COUNT(*) FROM product";
$result = mysqli_query($mysqli, $total_pages_sql);
$total_rows = mysqli_fetch_array($result)[0];
$total_pages = ceil($total_rows / $count_per_page);
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
            <h6>商品</h6>
            <a href='product_edit.php' class="btn"><span data-feather='plus'></span>新增</a>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>名称</th>
                        <th>价格</th>
                        <th>分类</th>
                        <th>创建时间</th>
                        <th>状态</th>
                        <th>上架时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql = "select * from product order by id desc LIMIT ?,? ";
                    $stmt = mysqli_prepare($mysqli, $sql);
                    mysqli_stmt_bind_param($stmt, 'ii', $offset, $count_per_page);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['id'];
                        echo "<tr>";
                        echo "<td>{$id}</td>";
                        echo "<td>{$row['name']}</td>";
                        echo "<td>{$row['price']}</td>";
                        echo "<td>{$row['cat']}</td>";
                        echo "<td>" . $row['create_time'] . "</td>";
                        echo "<td>{$row['publish_status']}</td>";
                        echo "<td>" . $row['publish_time'] . "</td>";
                        echo "<td><a href='product_edit.php?id=$id'><span data-feather='edit'></span></a>&nbsp;&nbsp;";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
                <ul class="pagination justify-content-center">
                    <li class="page-item">
                        <a class="page-link" href="?page=1">首页</a>
                    </li>
                    <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                        <a class="page-link" href="<?php echo $page <= 1 ? '#' : "?page=" . ($page - 1); ?>">上页</a>
                    </li>
                    <li class="page-item disabled">
                        <a class="page-link"><?php echo '第' . $page . '/' . $total_pages . '页'; ?></a>
                    </li>
                    <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                        <a class="page-link" href="<?php echo $page >= $total_pages ? '' : "?page=" . ($page + 1); ?>">下页</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $total_pages; ?>">末页</a>
                    </li>
                </ul>
            </div>
        </main>
    </div>
</div>
<?php require_once 'footer.php'; ?>
</body>
</html>
