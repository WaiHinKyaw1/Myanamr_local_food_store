<?php

require_once("../stroage/auth_user.php");
require_once("../layout/header.php");
require_once("../stroage/item_list.php");
$message = false;
if ($user['is_admin']) {
    header("Location:../layout/error.php");
}

if (isset($_GET['i_id'])) {
    $item = get_item_by_id($mysqli, $_GET['i_id']);
    $is_new = true;
    for ($i = 0; $i < count($item_list); $i++) {
        if ($_GET['i_id'] == $item_list[$i]['i_id']) {
            $is_new = false;
            if ($item['qty'] > $item_list[$i]['qty']) {
                $item_list[$i]['qty']++;
                $item_list[$i]['amount'] =
                    $item_list[$i]['qty'] * $item_list[$i]['price'];
            } else {
                $message = true;
            }
        }
    }
    if ($is_new) {
        array_push($item_list, [
            'i_id' => $item['i_id'],
            'c_id' => $user['c_id'],
            'price' => $item['price'],
            'i_name' => $item['i_name'],
            'qty' => 1,
            'img'=>$item['img'],
            'amount' => $item['price']
        ]);
    }
    $_SESSION['item_list'] = $item_list;
    if (!$message) {
        if (isset($_GET['b_id'])) {
            header("Location:../user/index.php?b_id=$_GET[b_id]");
        } else {
            header("Location:../user/index.php");
        }
    }
}

?>


<div class="root row">
    <div class="sidebar col-2">
        <a class="d-block text-dark text-decoration-none fs-4 text-center py-2" href="../user/index.php">All</a>
        <?php
        $brands = get_all_brand($mysqli);
        while ($brand = $brands->fetch_assoc()) {
        ?>
            <a class="d-block text-dark text-decoration-none fs-4 text-center py-2" href="../user/index.php?b_id=<?php echo $brand['brand_id'] ?>"><?php echo $brand['brand_name'] ?></a>

        <?php
        }
        ?>
    </div>
    <div class="content col-10 p-5">
        <?php if ($message) { ?>
            <div class="alert alert-danger">This item is not enought to add more!</div>
        <?php } ?>
        <div class="row">
            <?php
            $items = get_all_item($mysqli);
            if (isset($_GET['b_id'])) {
                $items = get_all_item_by_b_id($mysqli, $_GET['b_id']);
            }
            while ($item = $items->fetch_assoc()) {
                if ($item['qty'] > 0) {
            ?>
                    <div class="col-2">
                        <div class="card p-3 ">
                            <div style="height: 150px;">
                                <img class="rounded" style="width: 100%;height: 100%;" src="<?php if($item['img']) {
                                echo $item['img']; } else{
                                    echo "../upload/noimg.png";
                                }
                                 ?>">
                            </div>
                            <h5><?php echo $item['i_name'] ?></h5>
                            <p><?php echo $item['description'] ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div><?php echo $item['price'] ?> MMK</div>
                                <?php if (isset($_GET['b_id'])) { ?>
                                    <a href="../user/index.php?i_id=<?php echo $item['i_id'] ?>&b_id=<?php echo $item['b_id'] ?>" class="btn btn-primary">+</a>
                                <?php } else { ?>
                                    <a href="../user/index.php?i_id=<?php echo $item['i_id'] ?>" class="btn btn-primary">+</a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
            <?php }
            } ?>

        </div>
    </div>
</div>


<?php require_once("../layout/footer.php") ?>