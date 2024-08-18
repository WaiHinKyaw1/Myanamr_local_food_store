<?php
require_once("../storage/auth_user.php");

if (!$user['is_admin']) {
    header("Location: ../admin/layout/error.php");
    die();
}

?>
<?php
require_once("../storage/product_db.php");
require_once("../storage/brand_db.php");
require_once("../storage/database.php");
require_once("../admin/layout/header.php");

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete = delete_product($mysqli, $delete_id);
    if ($delete) {
        $_SESSION['status'] = "Delete Success";
        $_SESSION['status_code'] = "success";
        header("Location:../admin/product_list.php?status=$status");
        exit();
    } else {
        $_SESSION['status'] = "Delete Fail";
        $_SESSION['status_code'] = "error";
        header("Location: ../admin/product_list.php?status=$status");
        exit();
    }
}

?>
<?php require_once("../admin/layout/navbar.php");  ?>
<?php require_once("../admin/layout/sidebar.php"); ?>

<div class="dashboard-wrapper">
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <div class="row">
                <div class="col">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Exp_date</th>
                                <th scope="col">Discount</th>
                                <th scope="col">Image</th>
                                <th scope="col">Best Seller</th>
                                <th scope="col">IsNew</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result_per_page = 8;
                            if (isset($_GET['page'])) {
                                $page = $_GET['page'];
                            } else {
                                $page = 1;
                            }
                            $start_from = ($page - 1) * $result_per_page;
                            $products = get_all_product_with_limit($mysqli, $start_from, $result_per_page);

                            if (isset($_GET['search'])) {
                                $name = isset($_GET['search']) ? $_GET['search'] : null;
                                $products = get_product_by_filter($mysqli, $name);
                            }
                            ?>

                            <?php
                            $i = 1;
                            while ($product = $products->fetch_assoc()) : ?>

                                <tr>
                                    <th scope="row"><?php echo $i ?></th>
                                    <td><?= $product['product_name'] ?></td>
                                    <td><?= $product['price'] ?></td>
                                    <td class="d-flex justify-content-between"><?= $product['qty'] ?>  <a href="./add_qty.php?product_id=<?= $product['product_id'] ?>" > <h3><i class="fa-solid fa-square-plus"></i></h3></a></td>
                                    <td><?= $product['ex_date'] ?></td>
                                    <td><?= $product['discount'] ?></td>
                                    <td><a href="./add_qty.php?product_id=<?= $product['product_id'] ?>"><img style="width: 50px;height: 50px;" class="rounded" src="data:image/png;base64,<?php echo $product['image'] ?>" alt=""></a></td>
                                    <td>

                                        <?php if ($product['best_seller'] == 1) : ?>
                                            <a href="./best_seller.php?action=yes&product_id=<?php echo $product['product_id'] ?>" class="btn btn-primary btn-sm">Yes</a>
                                        <?php else : ?>
                                            <a href="./best_seller.php?action=no&product_id=<?php echo $product['product_id'] ?>" class="btn btn-warning btn-sm">No</a>
                                        <?php endif ?>

                                    </td>
                                    <td>
                                        <?php if ($product['is_new'] == 1) : ?>
                                            <a href="./is_new.php?action=yes&product_id=<?= $product['product_id'] ?>" class="btn btn-primary btn-sm">Yes</a>
                                        <?php else : ?>
                                            <a href="./is_new.php?action=no&product_id=<?= $product['product_id'] ?>" class="btn btn-warning btn-sm">No</a>
                                        <?php endif ?>
                                    </td>
                                    <td class="d-flex align-items-center">
                                        <a href="../admin/product.php?update_id=<?= $product['product_id'] ?>" class="btn btn-secondary btn-sm me-1 mt-2"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="../admin/product_list.php?delete_id=<?= $product['product_id'] ?>" class="btn btn-danger btn-sm mt-2"><i class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>

                            <?php
                                $i++;
                            endwhile ?>
                            
                </div>
                </tbody>
                </table>
                <div class="pagination">
                    <?php
                    $total_records = get_all_product($mysqli)->num_rows;

                    echo "</br>";
                    $total_pages = ceil($total_records / $result_per_page);
                    $pagLink = "";

                    if ($page >= 2) {
                        echo "<a href='product_list.php?page=" . ($page - 1) . "'>  Prev </a>";
                    }

                    for ($i = 1; $i <= $total_pages; $i++) {
                        if ($i == $page) {
                            $pagLink .= "<a class = 'active' href='product_list.php?page="
                                . $i . "'>" . $i . " </a>";
                        } else {
                            $pagLink .= "<a href='product_list.php?page=" . $i . "'>   
                                                " . $i . " </a>";
                        }
                    };
                    echo $pagLink;

                    if ($page < $total_pages) {
                        echo "<a href='index.php?page=" . ($page + 1) . "'>  Next </a>";
                    }

                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php require_once("../admin/layout/footer.php") ?>