<?php
include "session.php";
include "php/inputCheckHandler.php";
include "php/transferFundHandler.php";
if (isset($_POST["submitClicked"])) {
    verifyTransaction($connect);
}
include "php/formValidateHelper.php";
include "php/accountSelectHelper.php"
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
                <h1>Transfer to own account</h1>
                <form class="form-validate" method="post" novalidate>
                    <?php genericValidate();
                    balanceVaidate(); ?>
                    <div class="form-group mb-3">
                        <label for="from-account-select">Transfer from:</label>
                        <select class="custom-select" size="4" id="from-account-select" name="accountId" required="true">
                            <?php generateAccountSelect($connect, 0); ?>
                        </select>
                        <div class="invalid-feedback">
                            Please make a valid selection
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="to-account-select">Transfer to:</label>
                        <select class="custom-select" size="4" id="to-account-select" name="otherAccountId" required="true">
                            <?php generateAccountSelect($connect, 1); ?>
                        </select>
                        <div class="invalid-feedback">
                            Please make a valid selection
                        </div>
                    </div>

                    <label for="transfer-amount">Amount:</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        <input class="form-control" type="text" id="transfer-amount" name="amountIn" max length="45" placeholder="Enter amount" pattern="[0-9]+.?[0-9]*" required="true" title="Enter a valid amount to transfer, accepts numbers only" value="<?php echo sanitize_input($_POST["amountIn"]); ?>">
                        <div class="invalid-feedback">
                            Please use only numbers to enter a valid amount
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary submit-button" name="submitClicked" value=1 type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <?php include "footer.inc.php"; ?>
</body>

</html>