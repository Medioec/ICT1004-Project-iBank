<?php
include "session.php";
include "php/connect.php";
include "php/balanceHandler.php";
include "php/balanceDatatable.php";
include "php/inputCheckHandler.php";
if (isset($_POST["accountId"])) {
    $_SESSION["selectedAccount"] = sanitize_input($_POST["accountId"]);
    header("Location: accounts_manage.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include "head.inc.php"; ?>

<body>
    <?php include "nav.inc.php"; ?>
    <div class="page-bg"></div>
    <div class="page-body minw-500">
        <div class="page-content minw-500">
            <?php include "sideMenu.inc.php"; ?>
            <div class="main-content">
                <h2>Account Balances</h2>
                <?php $_SESSION["originTransactionPage"] = $_SERVER['REQUEST_URI'];
                getBalance($connect); ?>
            </div>
        </div>
    </div>
    <?php include "footer.inc.php"; ?>
</body>

</html>