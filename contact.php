<?php 
require_once("./user/layout/header.php"); 
require_once("./user/layout/navbar.php");
require_once("./storage/database.php");
require_once("./storage/feedback_db.php");
 ?>

<?php 
if(isset($_POST['feedback'])){
    
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $feed_back = save_feedback($mysqli,$name,$email,$message);
}
?>

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="./image/breadcrumb.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Contact Us</h2>
                        <div class="breadcrumb__option">
                            <a href="./index.php">Home</a>
                            <span>Contact Us</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Contact Section Begin -->
    <section class="contact spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="icon_phone"></span>
                        <h4>Phone</h4>
                        <p>09-946386596</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="icon_pin_alt"></span>
                        <h4>Address</h4>
                        <p>Kamayut,Yangon</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="icon_clock_alt"></span>
                        <h4>Open time</h4>
                        <p>10:00 am to 23:00 pm</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 text-center">
                    <div class="contact__widget">
                        <span class="icon_mail_alt"></span>
                        <h4>Email</h4>
                        <p>myanamr_local_food@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Section End -->

    <!-- Map Begin -->
    <div class="map">
    <div id="map"></div>
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3819.073153167395!2d96.11740794219675!3d16.82272664276874!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30c194cd7267146b%3A0x91eaee607eaf334a!2sKyun%20Chan%207%20St%2C%20Yangon!5e0!3m2!1sen!2smm!4v1725119303512!5m2!1sen!2smm" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        <div class="map-inside">
            <i class="icon_pin"></i>
            <div class="inside-widget">
                <h4>Yangon</h4>
                <ul>
                    <li>Phone: +95 9946386596</li>
                    <li>Add: Near Kuan Chan 7 St,Yangon Myanmar(Burma ) </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Map End -->

    <!-- Contact Form Begin -->
    <div class="contact-form spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="contact__form__title">
                        <h2>Leave Message</h2>
                    </div>
                </div>
            </div>
            <form action="./contact.php" method="post">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <input type="text" name="name" required="" placeholder="Your name">
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <input type="text" name="email" required="" placeholder="Your Email">
                    </div>
                    <div class="col-lg-12 text-center">
                        <textarea name="message" required="" placeholder="Your message"></textarea>
                        <button type="submit" name="feedback" class="site-btn">SEND MESSAGE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Contact Form End -->
    <?php require_once("./user/layout/footer.php") ?>