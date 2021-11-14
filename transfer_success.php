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
                        <h2>Transaction Complete</h2>
                        <p>You have successfully transferred $<?php echo $_SESSION["amountIn"];?> to Account no. <?php echo $_SESSION["otherAccountId"];?>.<p>

                    </div>
                    <?php include "php/transferUnset.php";?>
                </div>
                <?php include "footer.inc.php";?>
            </div>
    </body>
</html>