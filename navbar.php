<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#">PHP商城</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar1"
            aria-controls="navbar1" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbar1">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">首页 <span class="sr-only">(当前)</span></a>
            </li>
            <?php if (!isset($_SESSION['login'])) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">登录</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reg.php">免费注册</a>
                </li>
            <?php } else { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown01"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $_SESSION['nickname']; ?>, 我的</a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                        <a class="dropdown-item" href="my_order.php">我的订单</a>
                        <a class="dropdown-item" href="logout.php">退出</a>
                    </div>
                </li>
            <?php } ?>
            <li class="nav-item right">
                <a class="nav-link" href="cart.php">购物车</a>
            </li>
        </ul>
    </div>
</nav>
