<?php require_once("./layout/header.php")?>
<?php require_once("./layout/navbar.php")?>
<?php require_once("./layout/sidebar.php")?>
<div class="dashboard-wrapper">
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <div class="row ">
            <form action="/customers/profile/" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrfmiddlewaretoken" value="MH6IW1drn208AyPQTfBrkHDBjyCVtwyuWQoCXQrym2x6JX17ZNUPWYPrIJxUPY4f">
                <div class="col col-xl-8 mx-auto">
                    <div class="card card-body bg-white border-light shadow-sm mb-4">
                        <h2 class="h5 mb-4">Profile information</h2>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div>
                                    <label for="first_name">First Name</label>
                                    <input name="first_name" class="form-control" id="first_name" type="text"
                                           placeholder="Enter your first name" value="John"
                                           required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div>
                                    <label for="last_name">Last Name</label>
                                    <input name="last_name" class="form-control" id="last_name" type="text"
                                           placeholder="Also your last name" value="Doe"
                                           required>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-md-6 mb-3">
                                <label for="birthday">Birthday</label>
                                <div class="input-group">
                                    <span class="input-group-text"><span class="far fa-calendar-alt"></span></span>
                                    <input name="birthday" data-datepicker="" class="form-control" id="birthday"
                                           type="text" placeholder="dd/mm/yyyy" value="11/28/1984" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="gender">Gender</label>
                                <select name="gender" class="form-select mb-0" id="gender"
                                        aria-label="Gender select example">
                                    <option selected>Gender</option>
                                    
                                        <option value="1"
                                                selected>Male</option>
                                    
                                        <option value="2"
                                                >Female</option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input name="email" class="form-control" id="email" type="email"
                                           placeholder="name@company.com" value="test@appseed.yyyy" readonly>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input name="phone" class="form-control" id="phone" type="number"
                                           placeholder="+12-345 678 910" value="9132456521" required>
                                </div>
                            </div>
                        </div>
                        <h2 class="h5 my-4">Address</h2>
                        <div class="row">
                            <div class="col-sm-9 mb-3">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input name="address" class="form-control" id="address" type="text"
                                           placeholder="Enter your home address" value="Ward no.24,Sikit Nagar" required>
                                </div>
                            </div>
                            <div class="col-sm-3 mb-3">
                                <div class="form-group">
                                    <label for="number">Number</label>
                                    <input name="number" class="form-control" id="number" type="number"
                                           placeholder="No." value="1235" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 mb-3">
                                <div class="form-group">
                                    <label for="city">City</label>
                                    <input name="city" class="form-control" id="city" type="text" placeholder="City"
                                           value="Bhilai" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="zip">ZIP</label>
                                    <input name="zip" class="form-control" id="zip" type="tel" placeholder="ZIP"
                                           value="490025" required>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Save All</button>
                        </div>
                    </div>
                </div>
                
            
        </form>

        
        

            </div>
        </div>
    </div>
</div>           
<?php require_once("./layout/footer.php") ?>