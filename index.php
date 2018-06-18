<?php require_once('mysql.php'); ?>
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

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <div class="wrap">
                    <div class="all-sort-list">
                        <?php
                        $sql = "select * from category order by length(code)";
                        $result = mysqli_query($mysqli, $sql);
                        $menu = []; // similar with python dict
                        while ($row = mysqli_fetch_assoc($result)) {
                            $menu[$row['code']] = $row['name'];
                        }
                        foreach ($menu as $k1 => $v1) {
                            if (strlen($k1) == 2) {
                                echo "<div class='item'>";
                                echo "<h3><a href='list.php?cat={$k1}'>${v1}</a></h3>";
                                echo '<div class="item-list clearfix">';
                                echo '<div class="close">x</div>';
                                echo '<div class="subitem">';

                                $index = 1;
                                foreach ($menu as $k2 => $v2) {
                                    if (strlen($k2) == 4 && substr($k2, 0, 2) == $k1) {
                                        echo "<dl class='fore{$index}'>";
                                        echo "<dt><a href='list.php?cat={$k2}'>${v2}</a></dt>";
                                        echo "<dd>";
                                        foreach ($menu as $k3 => $v3) {
                                            if (strlen($k3) == 6 && substr($k3, 0, 4) == $k2) {
                                                echo "<em><a href='list.php?cat={$k3}'>${v3}</a></em>";
                                            }
                                        }
                                        echo '</dd>';
                                        echo '</dl>';
                                        $index++;
                                    }
                                }
                                echo '</div></div></div>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </nav>
        <main role="main" class="container">
            <div class="row">
                <?php
                $sql = "select * from product limit 10";
                $result = mysqli_query($mysqli, $sql);
                while ($row = mysqli_fetch_array($result)) {
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
</div>

<?php require_once 'footer.php'; ?>

</body>
</html>
