<?php
require_once 'mysql.php';
$count_per_page = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $count_per_page;

$total_pages_sql = "SELECT COUNT(*) FROM user";
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
            <h6>用户</h6>
            <a href='#' class='btn'><span data-feather='plus'></span>新增</a>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>邮箱</th>
                        <th>昵称</th>
                        <th>找回码</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql = "select * from user LIMIT ?,?";
                    $stmt = mysqli_prepare($mysqli, $sql);
                    mysqli_stmt_bind_param($stmt, 'ii', $offset, $count_per_page);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['id'];
                        echo "<tr>";
                        echo "<td>{$id}</td>";
                        echo "<td>{$row['email']}</td>";
                        echo "<td>{$row['nickname']}</td>";
                        echo "<td>{$row['find_code']}</td>";
                        echo "<td><a href='#' data-id='{$id}' class='user_edit'><span data-feather='edit'></span></a></td>";
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

<!--modal（！=model）为bootstrap的一个js？？控件，dialog对话窗功能-->
<div class="modal" tabindex="-1" role="dialog" id="editUserModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">编辑用户</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group row">
                        <label for="id" class="col-sm-2 col-form-label">序号</label>
                        <input type="text" class="form-control col-sm-8" id="id" name="id" readonly>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">邮箱</label>
                        <input type="email" class="form-control col-sm-8" id="email" name="email">
                    </div>
                    <div class="form-group row">
                        <label for="nickname" class="col-sm-2 col-form-label">昵称</label>
                        <input type="text" class="form-control col-sm-8" id="nickname" name="nickname">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnSaveUser">保存</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
<script>
    $("a.btn").on('click', function () {
        $('#editUserModal').modal('show');
    });

    $("td a.user_edit").on('click', function () {
        var id = $(this).data('id');

        $.ajax({
            url: 'user_load.php',
            data: {id: id},
            dataType: 'json'
        }).done(function (data) {
            var user = data;
            $('#id').val(user.id); //给modal的id，email，nickname绑定user_load.php返回的信息
            $('#email').val(user.email);
            $('#nickname').val(user.nickname);
            $('#editUserModal').modal('show'); //使id为editUserModal的modal显示出来
        });
    });
    $('#btnSaveUser').click(function () {
        $.ajax({
            url: 'user_edit.php',
            method: 'post',
            data: {
                id: $('#id').val(),
                email: $('#email').val(),
                nickname: $('#nickname').val()
            },
            dataType: 'json'
        }).done(function (data) {
            if (data.success) {
                $('#editUserModal').modal('hide');
                location.reload();
            }
        });
    });
</script>
</body>
</html>
