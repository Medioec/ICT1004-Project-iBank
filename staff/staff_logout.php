<?php
include "staff_session.php";
ob_start();
?>
<!DOCTYPE html>
<html>
<?php include "staff_head.inc.php"; ?>

<body>
    <?php include "staff_nav.inc.php"; ?>
    <div class="page-bg"></div>
    <main class="page-body minw-500">
        <div class="page-content minw-500">
            <div class="main-content">
                <?php include "staff_logout_handler.php"; ?>
            </div>
        </div>
    </main>
    <?php include "staff_footer.inc.php"; ?>
</body>

</html>