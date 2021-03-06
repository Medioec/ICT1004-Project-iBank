<?php
include "session.php";
include "php/connect.php";
include "php/balanceHandler.php";
include "php/balanceDatatable.php";
include "php/inputCheckHandler.php";
include "php/formValidateHelper.php";
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
    <main class="page-body minw-500">
        <div class="page-content minw-500">
            <?php include "sideMenu.inc.php"; ?>
            <div class="main-content">
                <h1>Account Balances</h1>
                <?php $_SESSION["originTransactionPage"] = $_SERVER['REQUEST_URI'];
                getBalance($connect); ?>
            </div>
        </div>
    </main>
    <?php include "footer.inc.php"; ?>
</body>

</html>