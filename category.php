<?php
require_once 'mysql.php';
$count_per_page = 10; //指定每页10rows
$page = isset($_GET['page']) ? $_GET['page'] : 1; //当前页码数，若url中未设置?page=,则默认页码为1
$offset = ($page - 1) * $count_per_page; //跳过，ex，选择第三页，则应显示第21-30rows，所以要在db中提取数据时，跳过前20个
                                        //所以 （3-1）*10 = 20，即为跳过前20条记录
$total_pages_sql = "SELECT COUNT(*) FROM category"; //db中总记录条数
$result = mysqli_query($mysqli, $total_pages_sql); //返回查询后的结果
$total_rows = mysqli_fetch_array($result)[0]; //mysql_fetch_array() 是 mysql_fetch_row() 的扩展版本。
                                              //除了将数据以数字索引方式储存在数组中之外，
                                              //还可以将数据作为关联索引储存，用字段名作为键名。
$total_pages = ceil($total_rows / $count_per_page); //ceil天花板，1.4->2，2.2->3，比当前值大的整数
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
            <h6>商品分类</h6>
            <a href="category_edit.php" class="btn"><span data-feather="plus"></span>新增</a>
<!--            새로 추하하기땜에 아래 수정 버튼 처럼 링크 뒤애 ?id=$id 붙이지않음-->
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>编码</th>
                        <th>名称</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql = "select * from category LIMIT ?,?"; // LIMIT ?,? 跳过多少条，取多少条
                    $stmt = mysqli_prepare($mysqli, $sql);
                    mysqli_stmt_bind_param($stmt,'ii',$offset,$count_per_page);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['id'];
                        echo "<tr>";
                        echo "<td>{$id}</td>";
                        echo "<td>{$row['code']}</td>";
                        echo "<td>{$row['name']}</td>";
                        echo "<td><a href='category_edit.php?id=$id'><span data-feather='edit'></span></a>&nbsp;&nbsp;";
                        echo "<a href='category_delete.php?id=$id'><span data-feather='delete'></span></a></td>";
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
