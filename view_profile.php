<html>
    <head>
    <?php
    include "head.inc.php";
    ?>
    </head>
    <body>
        <?php
        include "nav.inc.php";
        include "php/viewUserData.php"
        ?>
        
        
        <div class="page-bg"></div>
            <main class="page-body">
                <div class="page-content">
                    <div class="main-content">
                       
                        <h1>Hello, <?php $_SESSION[''] ?></h1>

                        <form>
                            <h4>Basic Info</h4>
                            <div class="form-group" id="nullable1">
                                <label for="fname">First name</label>
                                <input class="form-control" type="text" id="fname" required name="fname" value="<?php echo $fname ?>" disabled>
                            </div>
                            
                            <div class="form-group">
                                <label for="lname">Last name</label>
                                <input class="form-control" type="text" id="lname" required name="lname" value="<?php echo $lname ?>" disabled>
                            </div>

                            <div class="form-group">
                                <label for="lname">Full name</label>
                                <input class="form-control" type="text" id="fullname" required name="lname" value="<?php echo $fullname ?>" disabled>
                            </div>
                            
                            <div class="form-group">
                                <label for="street1">Street 1</label>
                                <input class="form-control" type="text" id="street1" required name="street1" value="<?php echo $street1 ?>" disabled>
                            </div>

                            <div class="form-group" id="nullable2">
                                <label for="street2">Street 2</label>
                                <input class="form-control" type="text" id="street2" required name="street2" value="<?php echo $street2 ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="postal">Postal</label>
                                <input class="form-control" type="text" id="postal" required name="postal" value="<?php echo $postal ?>" disabled>
                            </div>
                            
                            <h4>Contact Info</h4>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input class="form-control" type="email" id="email" required name="email" value="<?php echo $email ?>" disabled>
                            </div>
                            
                            <div class="form-group">
                                <label for="postal">Phone</label>
                                <input class="form-control" type="text" id="phone" required name="phone" value="<?php echo $phone?>" disabled>
                            </div>
                            

                            <div class="form-group">
                            <button class= "btn btn-primary" type="button" onClick="location.href='./update_profile.php'">Update Details</button>
                            </div>
                        </form>
                    </div>
                </div>
                
            <?php
                include "footer.inc.php";
            ?>
            </main>
        
        <!-- Check if nullable fields are empty -->
        <script>
            var nullable1 = document.getElementById("nullable1");
            var fname = document.getElementById("fname");
            
            var nullable2 = document.getElementById("nullable2");
            var street2 = document.getElementById("street2");
            
            if(fname.value === ""){
                nullable1.style.display = "none";
            }
            
            if(street2.value === ""){
                nullable2.style.display = "none";
            }
        </script>
        
        </div>
    </body>
</html>