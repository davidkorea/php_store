<?php
$script_name = basename($_SERVER['SCRIPT_NAME'], '.php');
// $_SERVER['SCRIPT_NAME'] 当前页面的完整url路径，ex：http://localhost:8080/php_store/category.php
// basename(url,suffix) 取路径最后的文件名category.php，通过参数suffix去掉.php
// 最终，当访问某分类页面时 $script_name = category
$module_name = explode("_", $script_name)[0];
// 对于 category_edit.php页面，会导致菜单高亮消失，所以类似python分割后取第一个script_name.split('_')[0]
?>
<nav class="col-md-2 d-none d-md-block bg-light sidebar">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link<?php echo $module_name == 'index' ? ' active' : ''; ?>"
                   href="index.php">
                    <span data-feather="home"></span>
                    首页
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?php echo $module_name == 'product' ? ' active' : ''; ?>"
                   href="product.php">
                    <span data-feather="shopping-cart"></span>
                    商品
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?php echo $module_name == 'category' ? ' active' : ''; ?>"
                   href="category.php">
                    <span data-feather="list"></span>
                    商品分类
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?php echo $module_name == 'user' ? ' active' : ''; ?>"
                   href="user.php">
                    <span data-feather="users"></span>
                    用户
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link<?php echo $module_name == 'order' ? ' active' : ''; ?>"
                   href="order.php">
                    <span data-feather="file"></span>
                    订单
                </a>
            </li>
        </ul>
    </div>
</nav>
