<script>   
    function go2Page()   
    {   
        var page = document.getElementById("page").value;   
        page = ((page><?php echo $total_pages; ?>)?<?php echo $total_pages; ?>:((page<1)?1:page));   
        window.location.href = './index.php?page='+page;   
    }   
  </script>  
  <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: 40.7128, lng: -74.0060 },
                zoom: 5
            });

            // Fetch data from PHP script
            fetch('data.php')
                .then(response => response.json())
                .then(locations => {
                    locations.forEach(location => {
                        new google.maps.Marker({
                            position: { lat: location.lat, lng: location.lng },
                            map: map,
                            title: location.title
                        });
                    });
                });
        }
    </script>
    <script async defer
        src="https://maps.app.goo.gl/kvqWXD9D7ANAjwdQ6">
    </script>
    <!-- Js Plugins -->
    <script src="./user/assets/js/jquery-3.3.1.min.js"></script>
    <script src="./user/assets/js/bootstrap.min.js"></script>
    <script src="./user/assets/js/jquery.nice-select.min.js"></script>
    <script src="./user/assets/js/jquery-ui.min.js"></script>
    <script src="./user/assets/js/jquery.slicknav.js"></script>
    <script src="./user/assets/js/mixitup.min.js"></script>
    <script src="./user/assets/js/owl.carousel.min.js"></script>
    <script src="./user/assets/js/main.js"></script>



</body>

</html>