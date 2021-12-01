<?php include "session.php";
if (!isset($_SESSION["transferSuccess"])) {
    header("Location: transfer_to_own.php");
} else {
    unset($_SESSION["transferSuccess"]);
    $amountIn = $_SESSION["amountIn"];
    $otherAccountId = $_SESSION["otherAccountId"];
    unset($_SESSION["accountId"]);
    unset($_SESSION["otherAccountId"]);
    unset($_SESSION["amountIn"]);
    unset($_SESSION["transferSuccess"]);
    unset($_SESSION["verified"]);
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include "head.inc.php"; ?>

<body>
    <?php include "nav.inc.php"; ?>
    <div class="page-bg"></div>
    <div class="page-body minw-500">
        <div class="page-content minw-500">
            <?php include "sideMenu.inc.php"; ?>
            <div class="main-content">
                <h2>Transaction Complete</h2>
                <p>You have successfully transferred $<?php echo $amountIn; ?> to Account no. <?php echo $otherAccountId; ?>.
                <p>
                    <a type="button" class="btn btn-primary" href="<?php echo $_SESSION["originTransactionPage"]; ?>">Back</a>
            </div>
        </div>
    </div>
    <?php include "footer.inc.php";?>
</body>

</html>