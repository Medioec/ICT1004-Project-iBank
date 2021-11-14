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
                    <div class="main-content">
                        <h2>Transfer to own account</h2>
                        <form action="transfer_confirm.php" method="post">
                            <?php 
                                include_once "php/transferValidateHelper.php";
                            ?>
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
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="to-account-select">Transfer to:</label>
                                </div>
                                <select class="custom-select" id="to-account-select" name="transferToAccountIn" required="true">
                                    <option value="">Choose account...</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="transfer-amount">Amount:</label>
                                <input class="form-control" type="number" id="transfer-amount" name="transferAmountIn"
                                    max length="45" placeholder="Enter amount" pattern="^[0-9]+$" required="true">
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php
                include "footer.inc.php";
            ?>
            </div>
    </body>
</html>