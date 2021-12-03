<?php //include "session.php";?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <?php
    include "head.inc.php";
    ?>
    </head>
    <body>
        <?php
        include "nav.inc.php";
        ?>  
        <div class="page-bg"></div>
            <main class="page-body">
                <div class="page-content">
                    <div class="main-content">
                        <h1 style="text-align:center"> <i class="bi bi-piggy-bank"></i> Become a OO4 Member <i class="bi bi-cash-coin"></i></h1><br>
                       
                        <form action="process_registration.php" method="post">
                            <p style="font-size:10px">Please complete the form below. <br> All fields marked with (*) are required</p>
                            <p class="h4">Personal Details</p><br>
                            <div class="form-group">
                                <label for="fname">First name</label>
                                <input class="form-control" type="text" id="fname" name="fname" maxlength="45" placeholder="Enter your First Name">
                            </div>
                            
                            <div class="form-group">
                                <label for="lname">Last name*</label>
                                <input class="form-control" type="text" id="lname" name ="lname" maxlength="45" placeholder="Enter your Last Name" required>
                            </div>
                            <div class="form-group">
                                <label for="fullname">Full name*</label>
                                <input class="form-control" type="text" id="fullname" name="fullname" maxlength="150" placeholder="Enter your Full Name" required>
                            </div>
                            <div class="form-group">
                                <label for="nric">NRIC / Passport No.*</label>
                                <input class="form-control" type="text" id="nric" name="nric" placeholder="Enter your NRIC / Passport Number" maxlength="9" required>
                            </div>
                            <div class="form-group">
                                <label for="dob">D.O.B*</label>
                                <input class="form-control" onfocus="(this.type='date')" id="dob" name="dob" placeholder="D.O.B (dd/mm/yyyy)" 
                                       oninvalid="this.setCustomValidity('Min. age for registration is 16 year old and above')" required>
                                <p style="font-size:10px"><em> (Min. age for registration is 16 year old and above.)</em></p>                           
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender*</label><br>
                                <select id="gender" name="gender" class="form-control">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="others">Others</option>
                                </select>
                            </div>
                            <hr>                            
                            
                            <p class="h4">Address</p><br>
                            <div class="form-group">
                                <label for="street1">Street 1*</label>
                                <input class="form-control" type="text" id="street1" name="street1" maxlength="100" placeholder="Street 1" required>
                            </div>
                            <div class="form-group">
                                <label for="street2">Street 2</label>
                                <input class="form-control" type="text" id="street2" name="street2" maxlength="100" placeholder="Street 2">
                            </div>
                            <div class="form-group">
                                <label for="postal">Postal*</label>
                                <input class="form-control" type="text" id="postal" name="postal" minlength="6" maxlength="6" placeholder="Postal Code" required>
                            </div>
                            <hr>
                            
                            <p class="h4">Contact Info</p><br>
                            <div class="form-group">
                                <label for="email">Email*</label>
                                <input class="form-control" type="email" id="email" name="email" maxlength="100" placeholder="Enter your Email address" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="phone">Phone*</label><br>
                                <input class="form-control" type="tel" id="phone" name="phone" size="150" maxlength="20" placeholder="Enter your Mobile Number" required>
                            </div>
                            <hr>
                            
                            <p class="h4">Login Details</p><br>

                            <div class="form-group">
                                <label for="username">Create a username*</label>
                                <input class="form-control" type="text" id="username" name="username" maxlength="30" placeholder="Username (This will be used for login)" maxlength="30" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="pwd">Set a Password*</label>  <i class="bi bi-eye-slash" id="togglePwd"></i>
                                <input class="form-control"  type="password" id="pwd" name="pwd" placeholder="Enter a password for your account" required>
                            </div>
      
                            <div class="form-group">
                                <label for="cfm_pwd">Confirm Password*</label>  <i class="bi bi-eye-slash" id="toggleCfmPwd"></i>
                                <input class="form-control" type="password" id="cfm_pwd" name="cfm_pwd" placeholder="Re-enter your password" required>
                            </div>

                            <div class="form-check">
                                <label>
                                    <input type="checkbox" name="agree" required>
                                    Agree to terms and conditions.
                                </label>
                            </div>
                            
                            <div class="form-group">
                            <button class= "btn btn-primary" type="submit">Sign Up</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php
                include "footer.inc.php";
            ?>
            </main>
        
        <script defer src="js/profile.js"></script>
        <script src="phonecc/js/intlTelInput.js"></script>
        <script>
        var input = document.querySelector("#phone");
        window.intlTelInput(input,({
            preferredCountries: ["sg", "my"],
            initialCountry : "sg"
        }));
 
        $(document).ready(function() {
            $('.iti__flag-container').click(function() { 
              var countryCode = $('.iti__selected-flag').attr('title');
              var countryCode = countryCode.replace(/[^0-9]/g,'');
              $('#phone').val("");
              $('#phone').val("+"+countryCode+" "+ $('#phone').val());
           });
        });
        </script>

        
        <script>
        // Min Age to setup account = 16 yo
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1;
        var yyyy = today.getFullYear() - 15;
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
        } 
        today = yyyy + '-' + mm + '-' + dd;
        document.getElementById("dob").setAttribute("max", today);
        </script>

    </body>
</html>
