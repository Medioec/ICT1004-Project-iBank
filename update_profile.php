<html>
    <head>
    <?php
    include "head.inc.php";
    ?>
    </head>
    <body>
        <?php
        include "nav.inc.php";
        include "php/viewUserData.php";
        ?>  
        <div class="page-bg"></div>
            <main class="page-body">
                <div class="page-content">
                    <div class="main-content">
                        <h1 style="text-align:center">Update Profile Details</h1>
                        
                        <p>*Implementing process_update_profile.php for user to update personal details*</p>

                        <form action="process_update_profile.php" method="post">
                            
                            <h4>Basic Info</h4>
                            <div class="form-group">
                                <label for="fname">First name</label>
                                <input class="form-control" type="text" id="fname" name="fname" value="<?php echo $fname ?>" >
                            </div>
                            
                            <div class="form-group">
                                <label for="lname">Last name</label>
                                <input class="form-control" type="text" id="lname" required name="lname" value="<?php echo $lname ?>" >
                            </div>

                            <div class="form-group">
                                <label for="lname">Full name</label>
                                <input class="form-control" type="text" id="fullname" required name="fullname" value="<?php echo $fullname ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="street1">Street 1</label>
                                <input class="form-control" type="text" id="street1" required name="street1" value="<?php echo $street1 ?>">
                            </div>

                            <div class="form-group">
                                <label for="street2">Street 2</label>
                                <input class="form-control" type="text" id="street2" name="street2"  value="<?php echo $street2 ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="postal">Postal</label>
                                <input class="form-control" type="text" id="postal" required name="postal"  value="<?php echo $postal ?>">
                            </div>
                            
                            <h4>Contact Info</h4>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input class="form-control" type="email" id="email" required name="email"  value="<?php echo $email ?>" >
                            </div>
                            
                            <div class="form-group">
                                <label for="postal">Phone</label>
                                <input class="form-control" type="text" id="phone" required name="phone"  value="<?php echo $phone ?>" >
                            </div>
                            
                            <h4>Password</h4>
                            
                            <div class="form-group">
                                <label>Change Password?</label><br>
                                  <input type="radio" id="y_changepwd" onclick="changepwdCheck()" name="changepwd" value="Yes">
                                  <label for="y_changepwd">Yes</label>
                                  <input type="radio" id="n_changepwd" onclick="changepwdCheck()" name="changepwd" value="No" checked="checked">
                                  <label for="n_changepwd">No</label><br>
                            </div>

                            <div class="form-group">
                                <label for="pwd">Enter Current Password</label>
                                <input class="form-control" type="password" id="pwd" required name="pwd">
                            </div>

                            <div class="form-group" id="ifYes">
                                <label for="new_pwd">New Password</label>
                                <input class="form-control" type="password" id="new_pwd" required name="new_pwd"><br>
                                
                                <label for="new_pwd">Confirm New Password</label>
                                <input class="form-control" type="password" id="cfm_pwd" required name="cfm_pwd">
                            </div>

                            
                            <div class="form-group">
                            <button class= "btn btn-primary" type="submit">Update</button>
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
