<?php session_start(); $_SESSION["transferInputVerified"] = 0;?>
<!DOCTYPE html>
<html>
    <?php include "head.inc.php"; ?>
    <body>
        <?php include "nav.inc.php"; ?>
        <div class="page-bg"></div>
            <div class="page-body minw-500">
                <div class="page-content minw-500">
                <?php include "sideMenu.inc.php";?>
                    <div class="main-content">
                        <h2>Transaction Complete</h2>
                        <p>You have successfully transferred $<?php echo $_SESSION["amountIn"];?> to Account no. <?php echo $_SESSION["otherAccountIdIn"];?>.<p>
                        <a type="button" class="btn btn-primary" href="<?php echo $_SESSION["originTransactionPage"];?>">Back</a>
                    </div>
                    <?php include "./php/transferUnset.php";?>
                </div>
                <?php include "footer.inc.php";?>
            </div>
    </body>
</html>