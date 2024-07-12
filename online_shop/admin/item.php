<?php

require_once("../stroage/auth_user.php");
require_once("../layout/header.php");
if (!$user) {
    header("Location:../auth/login.php");
} else {
    if (!$user['is_admin']) {
        header("Location:../layout/error.php");
    }
}

$i_name = $price = $qty = $b_id = $description = '';
$i_name_err = $price_err = $qty_err = $b_id_err = $description_err = $img_err = '';
$success = $invalid = '';

if (isset($_POST['submit'])) {
    $status = true;
    $i_name = $_POST['i_name'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];
    $b_id = $_POST['b_id'];
    $description = $_POST['description'];
    $img = $_FILES['img']['tmp_name'];
    $img_name = $_FILES['img']['name'];
    if (!str_contains($_FILES['img']['type'], 'image/')) {
        $status = false;
        $img_err = "Please upload only image!";
    } else {
        // try {
        //     // move_uploaded_file($img, "../upload/" . $img_name);
        // } catch (\Throwable $th) {
        //     $img_err = "Image upload error!";
        //     $status = false;
        // }
    }
    if ($i_name === "") {
        $status = false;
        $i_name_err = "Item name can't be Blank!";
    }
    if ($price === "" || !is_numeric($price)) {
        $status = false;
        $price_err = "Price shoule be Number!";
    }
    if ($qty === "" || !is_numeric($qty)) {
        $status = false;
        $qty_err = "Quenty shoule be Number!";
    }
    if ($b_id === "00") {
        $status = false;
        $b_id_err = "Please select Brand!";
    }
    if ($description === "") {
        $status = false;
        $description_err = "Description can't be Blank!";
    }
    if ($status) {
        $imgData = file_get_contents($img);
        $base64Str = base64_encode($imgData);
        $save = save_item($mysqli, $i_name, $price, $qty, $b_id, $description, $base64Str);
        if ($save) {
            $success = "New item is saved!";
            $i_name = $price = $qty = $b_id = $description = '';
        } else {
            $invalid = "Item can't be save!";
        }
    }
}


?>

<div class="root row">
    <div class="sidebar col-2">
        <a class="d-block text-dark text-decoration-none fs-4 text-center py-2" href="../admin/index.php">Brand</a>
        <a class="d-block text-dark text-decoration-none fs-4 text-center py-2" href="../admin/item.php">Item</a>
        <a class="d-block text-dark text-decoration-none fs-4 text-center py-2" href="../admin/order.php">Order</a>
    </div>
    <div class="content col-10 row">
        <div class="col-5 p-5 ">
            <div class="card p-5">
                <?php if ($success !== "") { ?>
                    <div class="alert alert-success"><?php echo $success ?></div>
                <?php } ?>
                <?php if ($invalid !== "") { ?>
                    <div class="alert alert-danger"><?php echo $invalid ?></div>
                <?php } ?>
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group my-3">
                        <label>Item Name</label>
                        <input name="i_name" type="text" value="<?php echo $i_name ?>" class="form-control">
                        <small class="text-danger"><?php echo $i_name_err ?></small>
                    </div>
                    <div class="form-group my-3">
                        <label>Price</label>
                        <input name="price" type="text" value="<?php echo $price ?>" class="form-control">
                        <small class="text-danger"><?php echo $price_err ?></small>
                    </div>
                    <div class="form-group my-3">
                        <label>Qty</label>
                        <input name="qty" type="text" value="<?php echo $qty ?>" class="form-control">
                        <small class="text-danger"><?php echo $qty_err ?></small>
                    </div>
                    <div class="form-group my-3">
                        <label>Brand</label>
                        <select name="b_id" class="form-select">
                            <option value="00">Select brand</option>
                            <?php $brands = get_all_brand($mysqli);
                            while ($brand = $brands->fetch_assoc()) {
                                $select = '';
                                if ($b_id == $brand['brand_id']) $select = "selected";
                            ?>

                                <option <?php echo $select ?> value="<?php echo $brand['brand_id'] ?>"><?php echo $brand['brand_name'] ?></option>
                            <?php } ?>
                        </select>
                        <small class="text-danger"><?php echo $b_id_err ?></small>
                    </div>


                    <div class="form-group my-3">
                        <label>Description</label>
                        <input name="description" type="text" value="<?php echo $description ?>" class="form-control">
                        <small class="text-danger"><?php echo $description_err ?></small>
                    </div>
                    <div class="form-group my-3">
                        <label>Item Image</label>
                        <input name="img" type="file" class="form-control">
                        <small class="text-danger"><?php echo $img_err ?></small>
                    </div>
                    <button name="submit" class="btn btn-primary my-3">Submit</button>
                </form>
            </div>
        </div>
        <div class="col-7 p-5">

            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Item Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Brand</th>
                        <th scope="col">Description</th>
                        <th scope="col">Item Image</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $items = get_all_item($mysqli);
                    $i = 1;
                    while ($item = $items->fetch_assoc()) {
                    ?>
                        <tr>
                            <th scope="row"><?php echo $i ?></th>
                            <td><?php echo $item['i_name'] ?></td>
                            <td><?php echo $item['price'] ?></td>
                            <td><?php echo $item['qty'] ?></td>
                            <td><?php echo $item['brand_name'] ?></td>
                            <td><?php echo $item['description'] ?></td>
                            <!-- <td><img style="width: 50px;height: 50px;" class="rounded" src="<?php
                                                                                                    // if ($item['img']) {
                                                                                                    //     echo $item['img'];
                                                                                                    // } else {
                                                                                                    //     echo "../upload/noimg.png";
                                                                                                    // }
                                                                                                    ?>"></td> -->
                            <td><img style="width: 50px;height: 50px;" class="rounded" src="data:image/png;base64,<?php echo $item['img'] ?>" alt=""></td>
                            <td>
                                <a href="../admin/item.php?update_id=<?php echo $brand['brand_id'] ?>" class="btn btn-secondary">Edit</a>
                                <a href="../admin/item.php?delete_id=<?php echo $brand['brand_id'] ?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php
                        $i++;
                    } ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<?php require_once("../layout/footer.php") ?>