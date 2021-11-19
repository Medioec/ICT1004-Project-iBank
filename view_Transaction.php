<?php 
    session_start(); 
    include "php/inputCheckHandler.php";
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
            <div class="page-body minw-500">
                <div class="page-content minw-500">
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
                        <h2>View transactions</h2>
                        <form class="form-validate" method="post" novalidate>
                            <?php include_once "php/viewTransactionValidateHelper.php";?>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="account-select">Account:</label>
                                </div>
                                <select class="custom-select" id="account-select" name="accountIn" required="true">
                                    <option value="">Choose account...</option>
                                    <?php include_once "php/viewTransactionAccountSelect.php";?>
                                </select>
                                <div class="invalid-feedback">
                                    Please make a valid selection
                                </div>
                            </div>
                            <div class="row">
                                <div class="date-entry form-group col-4">
                                    <label for="from-date">From Date:</label>
                                    <input type="date" class="form-control" id="from-date" name="fromDateIn" placeholder="From Date:"
                                    value="<?php echo sanitize_input($_POST["fromDateIn"]);?>">
                                </div>
                                <div class="date-entry form-group col-4">
                                    <label for="to-date">To Date:</label>
                                    <input type="date" class="form-control" id="to-date" name="toDateIn" placeholder="To Date:"
                                    value="<?php echo sanitize_input($_POST["toDateIn"]);?>">
                                </div>
                            </div>
                            <input type="hidden" name="submit-button-clicked" value="1"></input>
                            <div class="form-group">
                                <button class="btn btn-primary submit-button" type="submit">Submit</button>
                            </div>
                        </form>
                        <div class="table-responsive"><?php include "php/transactionViewHandler.php";?></div>
                    </main>
                </div>
                <?php include "footer.inc.php";?>
            </div>
    </body>
</html>