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
                        <?php
                        
                        // IMPLEMENTING CODES TO SELECT DATA FROM DB 
                        
                        ?>
                        <h1>Hello, $_SESSION['login_user']</h1>
                        
                        <p>*Implementing php codes to grab data from database and populate into fields*</p>

                        <form>
                            <h4>Basic Info</h4>
                            <div class="form-group">
                                <label for="fname">First name</label>
                                <input class="form-control" type="text" id="fname" required name="fname" value="<?php echo $row['first_name'] ?>" disabled>
                            </div>
                            
                            <div class="form-group">
                                <label for="lname">Last name</label>
                                <input class="form-control" type="text" id="lname" required name="lname" value="<?php echo $row['last_name'] ?>" disabled>
                            </div>
                            
                            <div class="form-group">
                                <label for="street1">Street 1</label>
                                <input class="form-control" type="text" id="street1" required name="street1" value="<?php echo $row['street1'] ?>" disabled>
                            </div>

                            <div class="form-group">
                                <label for="street2">Street 2</label>
                                <input class="form-control" type="text" id="street2" required name="street2" value="<?php echo $row['street2'] ?>" disabled>
                            </div>
                            
                            <div class="form-group">
                                <label for="postal">Postal</label>
                                <input class="form-control" type="text" id="postal" required name="postal" value="<?php echo $row['postal'] ?>" disabled>
                            </div>
                            
                            <h4>Contact Info</h4>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input class="form-control" type="email" id="email" required name="email" value="<?php echo $row['email'] ?>" disabled>
                            </div>
                            
                            <div class="form-group">
                                <label for="postal">Phone</label>
                                <input class="form-control" type="text" id="phone" required name="phone" value="<?php echo $row['phone'] ?>" disabled>
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
        </div>
    </body>
</html>