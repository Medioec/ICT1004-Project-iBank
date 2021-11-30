<?php 
include "session.php";
?>
<!DOCTYPE html>
<html lang="en">
    <?php include "head.inc.php";?>
    <body>
        <?php include "nav.inc.php";?>
        <div class="page-bg"></div>
            <div class="page-body minw-500">
                <div class="page-content minw-500">
                    <div class="main-content">
                    <?php include "php/logout_handler.php";?>
                    </div>
                </div>
                <?php include "footer.inc.php";?>
            </div>
    </body>
</html>