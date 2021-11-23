<?php //include "php/session.php";?>
<html>
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
                            
                            <h4>Name</h4><br>
                            <div class="form-group">
                                <label for="fname">First name</label>
                                <input class="form-control" type="text" id="fname" name="fname" placeholder="Enter your First Name">
                            </div>
                            
                            <div class="form-group">
                                <label for="lname">Last name</label>
                                <input class="form-control" type="text" id="lname" name ="lname" placeholder="Enter your Last Name" required>
                            </div>
                            <div class="form-group">
                                <label for="lname">Full name</label>
                                <input class="form-control" type="text" id="fullname" name="fullname" placeholder="Enter your Full Name" required>
                            </div>
                            <hr>
                            
                            <h4>Address</h4><br>
                            <div class="form-group">
                                <label for="street1">Street 1</label>
                                <input class="form-control" type="text" id="street1" name="street1" placeholder="Street 1" required>
                            </div>
                            <div class="form-group">
                                <label for="street2">Street 2</label>
                                <input class="form-control" type="text" id="street2" name="street2" placeholder="Street 2">
                            </div>
                            <div class="form-group">
                                <label for="postal">Postal</label>
                                <input class="form-control" type="text" id="postal" name="postal" placeholder="Postal Code" required>
                            </div>
                            <hr>
                            
                            <h4>Contact Info</h4><br>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input class="form-control" type="email" id="email" name="email" placeholder="Enter your Email address" required>
                            </div>
                            
                            <!-- TO DO Alter DB to allow char(20), accepting country code -->
                            <div class="form-group">
                                <label for="postal">Phone</label><br>
                                <input class="form-control" type="tel" id="phone" name="phone" size="150" placeholder="Enter your Mobile Number" required>
                            </div>
                            <hr>
                            
                            <h4>Password</h4><br>
                            
                            <div class="form-group">
                                <label for="pwd">Set a Password</label>
                                <input class="form-control" type="password" id="pwd" name="pwd" placeholder="Enter a password for your account" required>
                            </div>

                            <div class="form-group">
                                <label for="pwd">Confirm Password</label>
                                <input class="form-control" type="password" id="cfm_pwd" name="cfm_pwd" placeholder="Re-enter your password" required>
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
        
        <script src="phonecc/js/intlTelInput.js"></script>
        <script>
        // Vanilla Javascript
        var input = document.querySelector("#phone");
        window.intlTelInput(input,({
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
        </div>
    </body>
</html>
