<html>
    <head>
        <?php
        include "head.inc.php";
        ?>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </head>
    <body>
        <?php
        include "nav.inc.php";
        ?>  
        <div class="page-bg"></div>
            <main class="page-body">
                <div class="page-content">
                    <div class="main-content">
                        <h1>Member Login</h1>
                        <p>   
                            For New members, please register at the registration page
                            <a href="register.php">Sign Up page</a>. 
                        </p>
                        <form action="loginProcess.php" method="post">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input class="form-control" type="text" id="email" required name="username" size="30" maxlength="30" 
                                    placeholder="Enter username">
                            </div>

                            <div class="form-group">
                                <label for="pwd">Password:</label>
                                <input class="form-control" type="password" id="password" required name="password"
                                    placeholder="Enter password">
                            </div>
                            
                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="6Lcj-EQUAAAAAOR5N9iKG3EUYwJGecrPrCl4rJrc"></div>
                            </div>
                            <div class="form-group">
                                <button class= "btn btn-primary" type="submit" name="submit">Submit</button>
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
