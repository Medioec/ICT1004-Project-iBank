<?php
    session_start();
    include "php/transferFundHandler.php";
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
                        <h2>Verify Transaction Details</h2>
                        <p>You are about to transfer $<?php echo $_SESSION["amountIn"];?> to:</p> 
                        <p>Account no: <?php echo $_SESSION["fetchedOtherAccountId"];?></p> 
                        <p>Please confirm if you wish to proceed with the transaction.</p>
                        <?php echo $_SESSION["originTransactionPage"]."test";?>
                        
                        <form method="post">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="transferConfirmationCheckbox" required="true">
                                <label class="form-check-label" for="transferConfirmationCheckbox">I wish to proceed</label>
                            </div>
                            <?php $_SESSION["verifyTransfer"] = 1;?>
                            <div class="form-group">
                                <a type="button" class="btn btn-secondary" href="<?php echo $_SESSION["originTransactionPage"];?>">Back</a>
                                <button type="submit" class="btn btn-danger">Submit</button>
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