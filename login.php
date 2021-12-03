<!DOCTYPE html>
<html lang="en">
    <?php
    include "head.inc.php";
    ?>
    <body>
        <?php
        include "nav.inc.php";
        ?>  
        <div class="page-bg"></div>
            <main class="page-body">
                <div class="page-content">
                    <div class="main-content">
                        <h1>Login</h1>
                        <p>   
                            For new users, please register a new account  
                            <a href="registration.php">here</a>. 
                        </p>
                        <form action="loginProcess.php" method="post" class="form-validate" novalidate>
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input class="form-control" type="text" id="username" required name="username" size="30"
                                    placeholder="Enter username">
                                <div class="invalid-feedback">
                                    Please fill in your username
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input class="form-control" type="password" id="password" required name="password"
                                    placeholder="Enter password">
                                <div class="invalid-feedback">
                                    Please fill in your password
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="6Lcj-EQUAAAAAOR5N9iKG3EUYwJGecrPrCl4rJrc"></div>
                            </div>
                            <div class="form-group">
                                <button class= "btn btn-primary submit-button" type="submit" name="submit">Submit</button>
                            </div>
                        </form>
                        <p><a href="forget_password.php">Forget your password? </a></p>
                    </div>
                </div>
            </main>
            <?php include "footer.inc.php";?>
        </div>
    </body>
</html>
