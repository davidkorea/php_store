<?php
require_once 'mysql.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['id'] > 0) {
        $sql = "update category set `code`=?,`name`=? where id=?";
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, 'ssi', $_POST['code'], $_POST['name'], $_POST['id']);
        // s = str, i = int
    } else {
        $sql = "insert into category (`code`,`name`) VALUES (?,?)";
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, 'ss', $_POST['code'], $_POST['name']);
    }
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        header("Location: category.php");
        exit;
    } else {
        exit('商品分类新增/修改失败');
    }
}

$sql = "select * from category where id=?";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, 'i', $_GET['id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$id = $row['id'];
$code = $row['code'];
$name = $row['name'];
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
            <h6>商品分类-编辑</h6>
            <form action="category_edit.php" method="post">
                <div class="form-group row">
                    <label for="id" class="col-sm-2 col-form-label">序号</label>
                    <input type="text" class="form-control col-sm-6" id="id" name="id" value="<?php echo $id ?>"
                        readonly >
<!--                    <input type="text" class="form-control col-sm-6" id="id" name="id" value="--><?php //echo $id ?><!--"-->
<!--                           --><?php //echo $id == null ? '' : ' readonly';?><!-- >-->
<!--                         기능을 잘되는데 idx 직업 입력 필요없음, DB가 자동 생성됨-->
                </div>
                <div class="form-group row">
                    <label for="code" class="col-sm-2 col-form-label">编码</label>
                    <input type="text" class="form-control col-sm-6" id="code" name="code" value="<?php echo $code ?>">
                </div>
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">分类名称</label>
                    <input type="text" class="form-control col-sm-6" id="name" name="name" value="<?php echo $name ?>">
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
