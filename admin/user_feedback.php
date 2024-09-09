<?php
require_once("../storage/auth_user.php");
if (!$user) {
    header("Location: ./login.php");
    die();
} else {
    if (!$user['is_admin']) {
        header("Location: ../admin/layout/error.php");
        die();
    }
}
?>
<?php
require_once("../storage/database.php");
require_once("../storage/feedback_db.php");
require_once("../admin/layout/header.php");
require_once("../admin/layout/navbar.php"); 
require_once("../admin/layout/sidebar.php"); ?>

<div class="dashboard-wrapper">
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <div class="row">
                <div class="col">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Message</th>
                                <th scope="col">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                                <?php
                                $i=1;
                                $feedbacks = get_all_feedback($mysqli);
                                foreach($feedbacks as $feedback) : ?>
                            <tr>
                                <th scope="row"><?= $i ?></th>
                                <td><?= $feedback['name'] ?></td>
                                <td><?= $feedback['email'] ?></td>
                                <td><?= $feedback['message'] ?></td>
                                <td><?= $feedback['submitted_at'] ?></td>
                            </tr>
                                
                                <?php 
                                 $i++;
                                endforeach ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once("../admin/layout/footer.php") ?>
