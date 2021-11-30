<?php
include "session.php";
if (!$_SESSION["sqlFailed"]) {
    header("Location: accounts_view.php");
}
?>
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
            <div class="page-body minw-500">
                <div class="page-content minw-500">
                    <?php include "sideMenu.inc.php";?>
                    <div class="main-content">
                        <h2>Request Error</h2>
                        <p>An error has occured on the server side. Please try again at a later time.<p>
                        <a type="button" class="btn btn-primary" href="<?php echo $_SESSION["originTransactionPage"];?>">Back</a>
                    </div>
                </div>
                <?php include "footer.inc.php";?>
            </div>
    </body>
</html>