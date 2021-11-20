<?php 
    include "php/session.php";
    include "php/inputCheckHandler.php";
    include "php/transferFundHandler.php";
    if ($_SESSION["originTransactionPage"] != $_SERVER["REQUEST_URI"]) {
        include "php/transferUnset.php";
    }
?>
<!DOCTYPE html>
<html>
    <?php include "head.inc.php"; ?>
    <body>
        <?php include "nav.inc.php"; ?>
        <div class="page-bg"></div>
            <div class="page-body">
                <div class="page-content">
                    <div class="side-menu">
                        <h2>Links</h2>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <a class="side-menu-link text-secondary" href="accounts_view.php">View accounts</a>
                            </li>
                            <li class="list-group-item">
                                <a class="side-menu-link text-secondary" href="transfer_to_own.php">Transfer to own account</a>
                            </li>
                            <li class="list-group-item">
                                <a class="side-menu-link text-secondary" href="transfer_to_other.php">Transfer to other account</a>
                            </li>
                            <li class="list-group-item">
                                <a class="side-menu-link text-secondary" href="view_transaction.php">View transaction history</a>
                            </li>
                        </ul>
                    </div>
                    <main class="main-content">
                        <h2>Transfer to other account</h2>
                        <form class="form-validate" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" novalidate>
                            <?php include "php/transferValidateHelper.php"?>
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

                            <div class="form-group">
                                <label for="to_account_other_select">Enter account number:</label>
                                <input class="form-control" type="text" id="to_account_other_select" name="transferToAccountIn"
                                    max length="45" placeholder="Enter Account No." pattern="^[0-9]+$" required="true"
                                    value="<?php echo $_SESSION["otherAccountIdIn"];?>">
                            <div class="invalid-feedback">
                                Please enter an account number
                            </div>
                            </div>
                            

                            <div class="form-group">
                                <label for="transfer-amount">Amount:</label>
                                <input class="form-control" type="text" id="transfer-amount" name="transferAmountIn"
                                    max length="45" placeholder="Enter amount" pattern="^[0-9]+$" required="true"
                                    value="<?php echo $_SESSION["amountIn"];?>">
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
