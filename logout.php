<?php
include "session.php";
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<?php include "head.inc.php"; ?>

<body>
    <?php include "nav.inc.php"; ?>
    <div class="page-bg"></div>
    <main class="page-body minw-500">
        <div class="page-content minw-500">
            <div class="main-content">
                <?php include "php/logout_handler.php"; ?>
            </div>
        </div>
    </main>
    <?php include "footer.inc.php"; ?>
</body>

</html>
