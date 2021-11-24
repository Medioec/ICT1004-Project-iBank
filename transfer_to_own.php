<?php
    include "session.php";
    include_once "php/transferFundHandler.php";
    include_once "php/inputCheckHandler.php";
    if ($_SESSION["originTransactionPage"] != $_SERVER["REQUEST_URI"]) {
        include "php/transferUnset.php";
    }
?>
<!DOCTYPE html>
<html>
    <?php include "head.inc.php";?>
    <body>
        <?php include "nav.inc.php";?>
        <div class="page-bg"></div>
            <div class="page-body">
                <div class="page-content">
                <?php include "sideMenu.inc.php";?>
                    <main class="main-content">
                        <h2>Transfer to own account</h2>
                        <form class="form-validate" method="post" novalidate>
                            <?php include "php/transferValidateHelper.php"; ?>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="from-account-select">Transfer from:</label>
                                </div>
                                <select class="custom-select" id="from-account-select" name="transferFromAccountIn" required="true">
                                    <option value="">Choose account...</option>
                                    <?php include "php/accountSelect.php";?>
                                </select>
                                <div class="invalid-feedback">
                                    Please make a valid selection
                                </div>
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="to-account-select">Transfer to:</label>
                                </div>
                                <select class="custom-select" id="to-account-select" name="transferToAccountIn" required="true">
                                    <option value="">Choose account...</option>
                                    <?php include "php/accountSelect2.php";?>
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
                                <input class="form-control" type="text" id="transfer-amount" name="transferAmountIn"
                                    max length="45" placeholder="Enter amount" pattern="[0-9]+.?[0-9]*" required="true" title="Enter a valid amount to transfer"
                                    value="<?php echo $_SESSION['amountIn'];?>">
                            <div class="invalid-feedback">
                                Please enter a valid amount
                            </div>
                            </div>
                            <input type="hidden" name="verifyTransfer" value = 1>
                            <div class="form-group">
                                <button class="btn btn-primary submit-button" type="submit">Submit</button>
                            </div>
                            <?php //include "php/transferUnset.php";?>
                        </form>
                    </main>
                </div>
            <?php include "footer.inc.php"; ?>
            </div>
    </body>
</html>