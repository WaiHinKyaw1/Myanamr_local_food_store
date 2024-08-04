<?php require_once("../storage/database.php") ?>
<?php require_once("../storage/user_db.php") ?>
<?php require_once("../storage/auth_user.php") ?>
<?php require_once("header.php") ?>
<?php
if ($user) {
    $email = $user['email'];
    $user = get_user_by_email($mysqli, $email);
}
if (isset($_POST['logout'])) {
    setcookie("user", "", -1, "/");
    header("Location: ../auth/login.php");
}
?>
<div class="dashboard-header">
    <nav class="navbar navbar-expand-lg bg-white fixed-top">
        <div class="ms ">
        <img src="./assets/images/zen_mark.jpg" style="width: 160%; height:50px;"  alt="">
        </div>
       

        <div class="collapse navbar-collapse " id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto navbar-right-top">
                <li class="nav-item">
                    <div id="custom-search" class="top-search-bar">
                        <form action="" method="get">
                        <input class="form-control" type="text" name="search" placeholder="Search..">              
                        </form>
                    </div>
                </li>
                <li class="nav-item dropdown nav-user">
                    <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="./assets/images/avator.jpg" alt="" class="user-avatar-md rounded-circle"></a>
                    <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                        <div class="nav-user-info">
                            <h5 class="mb-0 text-white nav-user-name"><?php echo $user['name'] ?> </h5>
                        </div>

                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modal-default"><i class="fas fa-user mr-2"></i>Account</a>


                        <a class="dropdown-item" href="#"><i class="fas fa-cog mr-2"></i>Setting</a>
                        <a class="dropdown-item" href="../auth/login.php"><i class="fas fa-power-off mr-2"></i>Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</div>
<?php require_once("footer.php") ?>