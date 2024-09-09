</div>
    <!-- jquery 3.3.1 -->
    <script src="../admin/assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <!-- bootstap bundle js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../admin/assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <!-- slimscroll js -->
    <script src="../admin/assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <!-- main js -->
    <script src="../admin/assets/libs/js/main-js.js"></script>
    <!-- chart chartist js -->
    <script src="../admin/assets/vendor/charts/chartist-bundle/chartist.min.js"></script>
    <!-- sparkline js -->
    <script src="../admin/assets/vendor/charts/sparkline/jquery.sparkline.js"></script>
    <!-- morris js -->
    <script src="../admin/assets/vendor/charts/morris-bundle/raphael.min.js"></script>
    <script src="../admin/assets/vendor/charts/morris-bundle/morris.js"></script>
    <!-- chart c3 js -->
    <script src="../admin/assets/vendor/charts/c3charts/c3.min.js"></script>
    <script src="../admin/assets/vendor/charts/c3charts/d3-5.4.0.min.js"></script>
    <script src="../admin/assets/vendor/charts/c3charts/C3chartjs.js"></script>
    <script src="../admin/assets/libs/js/dashboard-ecommerce.js"></script>
    <script src="../admin/assets/libs/js/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    <?php if (isset($_SESSION['status']) && isset($_SESSION['status_code'])) {  ?>                    
                    
                    swal({
                    title: "<?= $_SESSION['status'] ?>",
                    icon: "<?= $_SESSION['status_code'] ?>",
                    button: "Done!",
                    });
                <?php 
            unset($_SESSION['status']);
            unset($_SESSION['status_code']);
            } ?>            
</script>
 
</body>
</html>