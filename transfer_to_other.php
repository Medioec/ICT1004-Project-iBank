<?php 
    session_start();
    include "php/transferUnset.php";
?>
<!DOCTYPE html>
<html>
    <?php
        include "head.inc.php";
    ?>
    <body>
        <?php
            include "nav.inc.php";
        ?>
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
                        <form class="form-validate" action="transfer_confirm.php" method="post" novalidate>
                            <?php include "php/transferValidateHelper.php"?>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="from-account-select">Transfer from:</label>
                                </div>
                                <select class="custom-select" id="from-account-select" name="transferFromAccountIn" required="true">
                                    <option value="">Choose account...</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please make a valid selection
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="to_account_other_select">Enter account number:</label>
                                <input class="form-control" type="text" id="to_account_other_select" name="transferToAccountIn"
                                    max length="45" placeholder="Enter Account No." pattern="^[0-9]+$" required="true">
                            <div class="invalid-feedback">
                                Please enter an account number
                            </div>
                            </div>
                            

                            <div class="form-group">
                                <label for="transfer-amount">Amount:</label>
                                <input class="form-control" type="text" id="transfer-amount" name="transferAmountIn"
                                    max length="45" placeholder="Enter amount" pattern="^[0-9]+$" required="true">
                            <div class="invalid-feedback">
                                Please enter a valid amount
                            </div>
                            </div>
                            

                            <div class="form-group">
                                <button class="btn btn-primary submit-button" type="submit">Submit</button>
                            </div>
                        </form>
                    </main>
                </div>
            <?php
                include "footer.inc.php";
            ?>
            </div>
    </body>
</html>