<?php include "session.php";?>
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
                       
                        <h1><i style="color:red" class="bi bi-exclamation-circle"></i> You are Deleting your account <i style="color:red" class="bi bi-exclamation-circle"></i></h1>
                        
                        <form action="process_deactivate.php" method="post">
                            <h4 style="color:red">This action cannot be reverted</h4><br>
                            <div class="form-group">
                                <label for="pwd">Enter Password to proceed</label> <i class="bi bi-eye-slash" id="togglePwd"></i>
                                <input class="form-control" type="password" id="pwd" required name="pwd">
                            </div>

                            <div class="form-check">
                                <label>
                                    <input type="checkbox" name="agree" required>
                                    I am aware that this action cannot be reverted.
                                </label>
                            </div>
                            
                            <hr><br>

                            <div class="form-group">
                                <button class= "btn btn-danger" type="submit">Delete Account</button>
                            </div>
                        </form>
                    </div>
                </div>
                
            <?php
                include "footer.inc.php";
            ?>
            </main>
        
        <script defer src="js/profile.js"></script>
        
        </div>
    </body>
</html>