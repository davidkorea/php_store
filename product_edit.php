<?php
require_once 'mysql.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['id'] > 0) {
        $sql = "update product set `name`=?,`price`=?,cat=?,description=? where id=?";
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, 'sdssi', $_POST['name'], $_POST['price'],
            $_POST['cat'], $_POST['description'], $_POST['id']);
        // sdssi - d = decimal, exact num for price
    } else {
        $sql = "insert into product (`name`,`price`,`cat`,`description`,`create_time`) VALUES (?,?,?,?,now())";
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, 'sdss', $_POST['name'], $_POST['price'],
            $_POST['cat'], $_POST['description']);
    }
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        header("Location: product.php");
        exit;
    } else {
        exit('商品新增/修改失败');
    }
}

$sql = "select * from product where id=?";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, 'i', $_GET['id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$id = $row['id'];
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
            <h6>商品-编辑</h6>
            <form action="product_edit.php" method="post">
                <div class="form-group row">
                    <label for="id" class="col-sm-2 col-form-label">序号</label>
                    <input type="text" class="form-control col-sm-6" id="id" name="id" value="<?php echo $id ?>"
                           readonly>
                </div>
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">名称</label>
                    <input type="text" class="form-control col-sm-6" id="name" name="name"
                           value="<?php echo $row['name'] ?>">
                </div>
                <div class="form-group row">
                    <label for="price" class="col-sm-2 col-form-label">价格</label>
                    <input type="text" class="form-control col-sm-6" id="price" name="price"
                           value="<?php echo $row['price'] ?>">
                </div>
                <div class="form-group row">
                    <label for="cat" class="col-sm-2 col-form-label">分类</label>
                    <select name="cat" class="form-control col-sm-6" id="cat">
                        <?php
                        $sql = "select * from category where length(code) = 6 order by id";
                        $stmt = mysqli_prepare($mysqli, $sql);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);
                        while ($row2 = mysqli_fetch_assoc($result)) {
                            $selected = $row['cat'] == $row2['code'] ? 'selected' : '';
                            echo "<option value='{$row2['code']}' {$selected}>{$row2['name']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group row">
                    <label for="description" class="col-sm-2 col-form-label">详细描述</label>
                    <textarea class="form-control col-sm-6" id="description"
                              name="description"><?php echo $row['description'] ?></textarea>
<!--                 textarea - multi-lines input-->
                </div>
                <div class="form-group row">
                    <label for="create_time" class="col-sm-2 col-form-label">创建时间</label>
                    <input type="text" class="form-control col-sm-6" id="create_time" name="create_time"
                           value="<?php echo $row['create_time'] ?>" readonly>
                </div>
                <div class="form-group row">
                    <label for="publish_status" class="col-sm-2 col-form-label">发布状态</label>
                    <select id="publish_status" name="publish_status" class="form-control col-sm-6" disabled>
                        <option value="0" <?php echo $row['publish_status'] == 0 ? 'selected' : ''; ?>>未上架</option>
                        <option value="1" <?php echo $row['publish_status'] == 1 ? 'selected' : ''; ?>>已上架</option>
                    </select>
                </div>
                <div class="form-group row">
                    <label for="publish_time" class="col-sm-2 col-form-label">发布时间</label>
                    <input type="text" class="form-control col-sm-6" id="publish_time" name="publish_time"
                           value="<?php echo $row['publish_time'] ?>" readonly>
                </div>
                <button type="submit" class="btn btn-primary">修改</button>
                <button type="button" class="btn btn-secondary" onclick="history.back(-1);">返回</button>
            </form>
        </main>
    </div>
</div>
<?php require_once 'footer.php'; ?>
</body>
</html>
