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
                        <h1>Member Login</h1>
                        <p>   
                            For New members, please register at the registration page
                            <a href="register.php">Sign In page</a>. 
                        </p>
                        <form action="process_login.php" method="post">
                            <div class="form-group">
                            <label for="email">Email:</label>
                            <input class="form-control" type="email" id="email" required name="email"
                                placeholder="Enter email">
                            </div>

                            <div class="form-group">
                            <label for="pwd">Password:</label>
                            <input class="form-control" type="password" id="pwd" required name="pwd"
                                placeholder="Enter password">
                            </div>

                            <div class="form-check">
                            <label>
                                <input type="checkbox" name="agree">
                                Agree to terms and conditions.
                            </label>
                            </div>

                            <div class="form-group">
                            <button class= "btn btn-primary" type="submit">Submit</button>
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