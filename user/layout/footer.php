<script>   
    function go2Page()   
    {   
        var page = document.getElementById("page").value;   
        page = ((page><?php echo $total_pages; ?>)?<?php echo $total_pages; ?>:((page<1)?1:page));   
        window.location.href = './index.php?page='+page;   
    }   
  </script>  

    <script async defer
        src="https://maps.app.goo.gl/kvqWXD9D7ANAjwdQ6">
    </script>
    <!-- Js Plugins -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="./user/assets/js/jquery-3.3.1.min.js"></script>
    <script src="./user/assets/js/bootstrap.min.js"></script>
    <script src="./user/assets/js/jquery.nice-select.min.js"></script>
    <script src="./user/assets/js/jquery-ui.min.js"></script>
    <script src="./user/assets/js/jquery.slicknav.js"></script>
    <script src="./user/assets/js/mixitup.min.js"></script>
    <script src="./user/assets/js/owl.carousel.min.js"></script>
    <script src="./user/assets/js/main.js"></script>
    <script>
        <?php if (isset($_SESSION['status']) && isset($_SESSION['status_code'])) {  ?>                    
                    
            swal({
            title: "<?= $_SESSION['status'] ?>",
            icon: "<?= $_SESSION['status_code'] ?>",
            button: "Done!",
            });
        <?php 
    unset($_SESSION['status']);
    } ?>
    </script>
</body>

</html>