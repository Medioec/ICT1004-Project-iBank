<?php session_start();?>
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
                    <div class="main-content">
                        <h2>View transactions</h2>
                        <form method="post">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="account-select">Account:</label>
                                </div>
                                <select class="custom-select" id="account-select" name="accountIn" required="true">
                                    <option value="">Choose account...</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="date-entry form-group col-4">
                                    <label for="from-date">From Date:</label>
                                    <input type="date" class="form-control" id="from-date" name="fromDateIn" placeholder="From Date:">
                                </div>
                                <div class="date-entry form-group col-4">
                                    <label for="to-date">To Date:</label>
                                    <input type="date" class="form-control" id="to-date" name="toDateIn" placeholder="To Date:">
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </form>
                        <?php include "php/transactionViewHandler.php";?>
                    </div>
                </div>
                <?php include "footer.inc.php";?>
            </div>
    </body>
</html>