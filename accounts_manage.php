<?php
include "session.php";
include "php/connect.php";
include "php/inputCheckHandler.php";
include "php/transactionDatatable.php";
if (!isset($_SESSION["selectedAccount"])) {
    header("Location: accounts_view.php");
}
if (isset($_POST["deleteAccountClicked"])) {
    $_SESSION["deleteAccountClicked"] = 1;
    header("Location: accounts_delete.php");
}
$accountId = $fromDate = $toDate = "";
$accountId = $_SESSION["selectedAccount"];
$toDate = date("Y-m-d H:i:s");
$fromDate = date("Y-m-d", strtotime("-1 month"));

$action = "SELECT `account_id` FROM `bank_accounts_ref` WHERE (`account_id` = ? AND `customer_id` = ?);";

$stmt = $connect->prepare($action);
$stmt->bindParam(1, $accountId, PDO::PARAM_INT);
$stmt->bindParam(2, $_SESSION["customerId"], PDO::PARAM_INT);

try {
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Retrieve failed: " . $e->getMessage();
    $_SESSION["sqlFailed"] = 1;
}

if ($result[0]["account_id"] != NULL) {
    $fetchedAccountId = $result[0]["account_id"];
} else {
    $_SESSION["inputInvalid"] = 1;
}

$abort = checkValidNum($accountId) + checkValidNum($fromDate) + checkValidNum($toDate);
if ($abort) {
    $_SESSION["inputInvalid"] = 1;
}

$action = "SELECT * FROM `transaction_data` WHERE 
        ( (`credit_id` = ? OR `debit_id` = ?) AND (`timestamp` BETWEEN ? AND ?) ) 
        ORDER BY `timestamp` DESC;";

$stmt = $connect->prepare($action);
$stmt->bindParam(1, $fetchedAccountId, PDO::PARAM_INT);
$stmt->bindParam(2, $fetchedAccountId, PDO::PARAM_INT);
$stmt->bindParam(3, $fromDate, PDO::PARAM_STR);
$stmt->bindParam(4, $toDate, PDO::PARAM_STR);

try {
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Retrieve failed: " . $e->getMessage();
    $_SESSION["sqlFailed"] = 1;
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
            <div class="column-content">
                <div class="main-content">
                    <h2>Account Detail</h2>
                    <h3>Your transactions over the past month:</h3>
                    <?php
                    formTransactionTable($result, $accountId);
                    ?>
                </div>
                <div class="main-content">
                    <h2>Delete Account</h2>
                    <form method="post">
                        <button type="submit" class="btn btn-danger submit-button mt-3" name="deleteAccountClicked" value=1>Delete Account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include "footer.inc.php"; ?>
</body>

</html>