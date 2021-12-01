<?php
include "session.php";
include "php/inputCheckHandler.php";
if (
    !isset($_SESSION["originTransactionPage"]) ||
    (basename($_SESSION["originTransactionPage"]) != "transfer_to_own.php" &&
        basename($_SESSION["originTransactionPage"]) != "transfer_to_other.php")
) {
    header("Location: transfer_to_own.php");
}
if (!isset($_SESSION["verified"])) {
    header("Location: " . $_SESSION["originTransactionPage"]);
} else if (isset($_POST["confirmTransferClicked"])) {
    include "php/connect.php";
    include "php/transferFundHandler.php";
    executeTransaction($connect);
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include "head.inc.php"; ?>

<body>
    <?php include "nav.inc.php"; ?>
    <div class="page-bg"></div>
    <main class="page-body">
        <div class="page-content">
            <?php include "sideMenu.inc.php"; ?>
            <div class="main-content">
                <h1>Verify Transaction Details</h1>
                <p>You are about to transfer $<?php echo $_SESSION["amountIn"]; ?> to:</p>
                <p>Account no: <?php echo $_SESSION["otherAccountId"]; ?></p>
                <p>Please confirm if you wish to proceed with the transaction.</p>


                <form class="form-validate" method="post" novalidate>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="transferConfirmationCheckbox" required="true">
                        <label class="form-check-label mb-3" for="transferConfirmationCheckbox">I wish to proceed</label>
                    </div>
                    <input type="hidden" name="confirmTransferClicked" value=1>
                    <div class="form-group">
                        <a type="button" class="btn btn-secondary" href="<?php echo $_SESSION["originTransactionPage"]; ?>">Back</a>
                        <button type="submit" class="btn btn-danger submit-button">Transfer $<?php echo $_SESSION["amountIn"]; ?>
                            to account <?php echo $_SESSION["fetchedOtherAccountId"]; ?></button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <?php include "footer.inc.php"; ?>
</body>

</html>