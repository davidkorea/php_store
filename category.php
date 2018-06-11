<?php require_once 'mysql.php'; ?>
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
                    $sql = "select * from category";
                    $stmt = mysqli_prepare($mysqli, $sql);
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
            </div>
        </main>
    </div>
</div>
<?php require_once 'footer.php'; ?>
</body>
</html>
