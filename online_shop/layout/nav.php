<?php
require_once("../stroage/item_list.php");
if (isset($_COOKIE['user'])) {
    $user = json_decode($_COOKIE['user'], true);
}
if (isset($_POST['logout'])) {
    setcookie("user", "", -1, "/");
    header("Location:../auth/login.php");
}
?>
<nav class="d-flex align-items-center justify-content-between py-3 px-5">
    <div class="d-flex align-items-center">
        <img src="../assets/img/logo.png" class="logo rounded">
        <span class="fs-3 text-white ms-3">Online Shop</span>
    </div>
    <div class="d-flex align-items-center">
        <?php
        $item_count=0;
        foreach ($item_list as $itm) {
            $item_count = $item_count + $itm['qty'];
        }
        if ($user) {
            if (!$user['is_admin']) { ?>
                <a href="../user/order.php" class="me-5 text-dark text-decoration-none">Orders <span class="badge badge-light bg-danger"><?php if($item_count>0) echo $item_count ?></span></a>
           <?php }
        ?><form method="post">
                <button name="logout" class="btn btn-outline-primary">Logout</button>
            </form>
        <?php }
        ?>
    </div>
</nav>