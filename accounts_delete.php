<?php
include "session.php";
include "php/connect.php";
include "php/inputCheckHandler.php";
if (!isset($_SESSION["deleteAccountClicked"])) {
    header("Location: accounts_view.php");
}
if ($_POST["confirmDeleteClicked"]) {

    $logSql = "INSERT INTO `log`(`type`,`category`, `description`, `user_performed`, `timestamp`) VALUES (?,?,?,?,CURRENT_TIMESTAMP)";
    $logType0 = "BANKING DELETE";
    $logType1 = "BANKING DELETE FAIL";
    $logCategory0 = "INFO";
    $logCategory1 = "WARNING";
    $description = "";
    $table1Fail = 0;
    $table2Fail = 0;
    $success = 1;

    $accountId = $_SESSION["selectedAccount"];
    $action = "SELECT `account_id` FROM `bank_accounts_ref` WHERE (`account_id` = ? AND `customer_id` = ?);";

    $stmt = $connect->prepare($action);
    $stmt->bindParam(1, $accountId, PDO::PARAM_INT);
    $stmt->bindParam(2, $_SESSION["customerId"], PDO::PARAM_INT);

    try {
        $success = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $success = 0;
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
        $success = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $success = 0;
    }

    if (!$success) {
        $_SESSION["sqlFailed"] = 1;
        header("Location: request_error.php");
    }

    if ($result[0]["balance"]) {
        $pagecontent = '
        <h1>Deletion failed</h1>
        <p>There are still funds in your account, please transfer the remaining sum out of the account before deletion.</p>
        <a type="button" class="btn btn-secondary" href="' . $_SESSION["originTransactionPage"] . '">Back</a>         
        ';
    }

    if ($result[0]["balance"] == 0) {
        if ($fetchedAccountId != NULL) {
            /*($action = "DELETE `bank_accounts_ref`, `bank_account` FROM `bank_accounts_ref` INNER JOIN `bank_account`
                WHERE `bank_accounts_ref`.`account_id` = `bank_account`.`account_id` AND `bank_account`.`account_id` = ?;";*/

            $action = "DELETE FROM `bank_accounts_ref` WHERE `account_id` = ?;";

            $stmt = $connect->prepare($action);
            $stmt->bindParam(1, $fetchedAccountId, PDO::PARAM_INT);

            try {
                $success = $stmt->execute();
            } catch (PDOException $e) {
                $success = 0;
            }

            if (!$success) {
                $table1Fail = 1;
                $_SESSION["sqlFailed"] = 1;
                header("Location: request_error.php");
            } else {
                $action = "DELETE FROM `bank_account` WHERE `account_id` = ?;";

                $stmt = $connect->prepare($action);
                $stmt->bindParam(1, $fetchedAccountId, PDO::PARAM_INT);

                try {
                    $success = $stmt->execute();
                } catch (PDOException $e) {
                    $success = 0;
                }

                if (!$success) {
                    $table2Fail = 1;
                    $_SESSION["sqlFailed"] = 1;
                    header("Location: request_error.php");
                }
            }
            //SQL statements successfully executed
            if (!$table1Fail && !$table2Fail) {
                $pagecontent = '
                <h1>Account Deleted</h1>
                <p>You have successfully deleted account no: ' . $fetchedAccountId . '</p>
                <a type="button" class="btn btn-secondary" href="' . $_SESSION["originTransactionPage"] . '">Back</a>      
                ';

                //Create success log
                $action = $logSql;
                $description = "BANK ACCOUNT ".$fetchedAccountId." DELETED";
                $stmt = $connect->prepare($action);
                $stmt->bindParam(1, $logType0, PDO::PARAM_STR);
                $stmt->bindParam(2, $logCategory0, PDO::PARAM_STR);
                $stmt->bindParam(3, $description, PDO::PARAM_STR);
                $stmt->bindParam(4, $_SESSION["username"], PDO::PARAM_STR);
                try {
                    $stmt->execute();
                }
                catch(PDOException $e) {
                    //echo "Retrieve failed: " . $e->getMessage();
                }

                unset($_SESSION["selectedAccount"]);
                unset($_SESSION["deleteAccountClicked"]);

            } else {
                //Create fail log
                $action = $logSql;
                $description = "SQL FAILURE (Please escalate to db admin)";
                $stmt = $connect->prepare($action);
                $stmt->bindParam(1, $logType1, PDO::PARAM_STR);
                $stmt->bindParam(2, $logCategory1, PDO::PARAM_STR);
                $stmt->bindParam(3, $description, PDO::PARAM_STR);
                $stmt->bindParam(4, $_SESSION["username"], PDO::PARAM_STR);
                try {
                    $stmt->execute();
                }
                catch(PDOException $e) {
                    //echo "Retrieve failed: " . $e->getMessage();
                }
            }




        }
    }
} else if ($_SESSION["deleteAccountClicked"]) {

    $pagecontent = '
        <h1>Delete Confirmation</h1>
        <p>Are you sure you want to delete account ' . $_SESSION["selectedAccount"] . '?</p>
        <form method="post">
            <div class="form-group">
                <a type="button" class="btn btn-secondary" href="' . $_SESSION["originTransactionPage"] . '">Back</a>
                <button type="submit" class="btn btn-danger submit-button" name="confirmDeleteClicked" value=1>Delete</button>
            </div>
        </form>
    ';
} else {
    header("Location: accounts_view.php");
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
                <?php echo $pagecontent; ?>
            </div>
        </div>
    </main>
    <?php include "footer.inc.php"; ?>
</body>

</html>