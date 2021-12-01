<?php
include "session.php";
include "php/inputCheckHandler.php";
if (isset($_POST["submitClicked"])) {
    if ($_POST["submitClicked"] == 1);
    $_SESSION["submitClicked"] = 1;
    include "php/transferFundHandler.php";
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
    <div class="page-body">
        <div class="page-content">
            <?php include "sideMenu.inc.php"; ?>
            <main class="main-content">
                <h2>Transfer to other account</h2>
                <form class="form-validate" method="post" novalidate>
                    <?php genericValidate();
                    balanceVaidate(); ?>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="from-account-select">Transfer from:</label>
                        </div>
                        <select class="custom-select" id="from-account-select" name="accountId" required="true">
                            <option value="">Choose account...</option>
                            <?php generateAccountSelect($connect, 0); ?>
                        </select>
                        <div class="invalid-feedback">
                            Please make a valid selection
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="to_account_other_select">Enter account number:</label>
                        <input class="form-control" type="text" id="to_account_other_select" name="otherAccountId" max length="45" placeholder="Enter Account No." pattern="^[0-9]+$" required="true" value="<?php echo sanitize_input($_POST["otherAccountId"]); ?>">
                        <div class="invalid-feedback">
                            Please enter an account number
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="transfer-amount">Amount:</label>
                        <input class="form-control" type="text" id="transfer-amount" name="amountIn" max length="45" placeholder="Enter amount" pattern="^[0-9]+$" required="true" title="Enter a valid amount to transfer, accepts numbers only" value="<?php echo sanitize_input($_POST["amountIn"]); ?>">
                        <div class="invalid-feedback">
                            Please use only numbers to enter a valid amount
                        </div>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary submit-button" name="submitClicked" value=1 type="submit">Submit</button>
                    </div>
                </form>
            </main>
        </div>
    </div>
    <?php include "footer.inc.php"; ?>
</body>

</html>