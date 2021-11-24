<?php
include "session.php";
include "php/connect.php";
include "php/inputCheckHandler.php";
if (!isset($_SESSION["deleteAccountClicked"])) {
    header("Location: accounts_view.php");
}
if ($_POST["confirmDeleteClicked"]) 
{
    $accountId = $_SESSION["selectedAccount"];
    $action = "SELECT `account_id` FROM `bank_accounts_ref` WHERE (`account_id` = ? AND `customer_id` = ?);";

    $stmt = $connect->prepare($action);
    $stmt->bindParam(1, $accountId, PDO::PARAM_INT);
    $stmt->bindParam(2, $_SESSION["customerId"], PDO::PARAM_INT);

    try {
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e) {
        $_SESSION["sqlFailed"] = 1;
        header("Location: request_error.php");
    }

    $fetchedAccountId = $result[0]["account_id"];

    if ($fetchedAccountId == NULL) {
        $_SESSION["sqlFailed"] = 1;
        header("Location: request_error.php");
    }

    $action = "SELECT `balance` FROM `bank_account` WHERE `account_id` = ?;";

    $stmt = $connect->prepare($action);
    $stmt->bindParam(1, $fetchedAccountId, PDO::PARAM_INT);

    try {
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e) {
        $_SESSION["sqlFailed"] = 1;
        header("Location: request_error.php");
    }
    if ($result[0]["balance"]) {
        $pagecontent = '
        <h2>Deletion failed</h2>
        <p>There are still funds in your account, please transfer the remaining sum out of the account before deletion.</p>
        <a type="button" class="btn btn-secondary" href="'. $_SESSION["originTransactionPage"] .'">Back</a>         
        ';
    }

    if ($result[0]["balance"] == 0) 
    {
        if ($fetchedAccountId != NULL) 
        {
            $action = "DELETE `bank_accounts_ref`, `bank_account` FROM `bank_accounts_ref` INNER JOIN `bank_account`
                WHERE `bank_accounts_ref`.`account_id` = `bank_account`.`account_id` AND `bank_account`.`account_id` = ?;";

            $stmt = $connect->prepare($action);
            $stmt->bindParam(1, $fetchedAccountId, PDO::PARAM_INT);

            try {
                $stmt->execute();
            }
            catch(PDOException $e) {
                $_SESSION["sqlFailed"] = 1;
                header("Location: request_error.php");
            }
            $pagecontent = '
            <h2>Account Deleted</h2>
            <p>You have successfully deleted account no: '.$fetchedAccountId.'</p>
            <a type="button" class="btn btn-secondary" href="'. $_SESSION["originTransactionPage"] .'">Back</a>      
            ';
        }
    }
} else if ($_SESSION["deleteAccountClicked"]) {

    $pagecontent = '
        <h2>Delete Confirmation</h2>
        <p>Are you sure you want to delete account '. $_SESSION["selectedAccount"] .'?</p>
        <form method="post">
            <div class="form-group">
                <a type="button" class="btn btn-secondary" href="'. $_SESSION["originTransactionPage"] .'">Back</a>
                <button type="submit" class="btn btn-danger submit-button" name="confirmDeleteClicked" value=1>Delete</button>
            </div>
        </form>
    ';
} else {
    header("Location: accounts_view.php");
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
                    <?php include "sideMenu.inc.php";?>
                    <div class="main-content">
                        <?php echo $pagecontent;?>
                    </div>
                </div>
                <?php include "footer.inc.php";?>
            </div>
    </body>
</html>