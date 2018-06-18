<?php require_once ('mysql.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>PHP Store - Admin Console</title>

    <?php require_once ('header.php');?>

</head>

<body>
<?php require_once ('navbar.php');?>

<div class="container-fluid">
    <div class="row">
        <?php require_once ('sidebar.php');?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <h5>首页</h5>
            <?php
            if (isset($_GET['q'])) {
                ?>
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>名称</th>
                            <th>价格</th>
                            <th>分类</th>
                            <th>创建时间</th>
                            <th>上架状态</th>
                            <th>上架时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sql = "select p.*,c.name as cat_name from product p left join category c on p.cat = c.code";
                        $sql .= " WHERE p.description LIKE ? ORDER BY id ";
                        $like = '%' . $_GET['q'] . '%'; // % means any characters before of after it
                        $stmt = mysqli_prepare($mysqli, $sql);
                        mysqli_stmt_bind_param($stmt, 's', $like);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row['id'];
                            echo "<tr>";
                            echo "<td>{$id}</td>";
                            echo "<td>{$row['name']}</td>";
                            echo "<td>{$row['price']}</td>";
                            echo "<td>{$row['cat_name']}</td>";
                            echo "<td>" . $row['create_time'] . "</td>";
                            echo "<td>" . show_product_publish_status($row['publish_status']) . "</td>";
                            echo "<td>" . $row['publish_time'] . "</td>";
                            echo "<td><a href='product_edit.php?id=$id'><span data-feather='edit'></span></a>&nbsp;&nbsp;</td>";
                            echo "</tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </main>
    </div>
</div>

<?php require_once ('footer.php');?>

</body>
</html>