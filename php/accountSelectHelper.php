<?php
function generateAccountSelect($connect, $displayTarget) {
    if ($displayTarget == 0) {
        if (isset($_POST["accountId"])) {
            $accountToSelect = sanitize_input($_POST["accountId"]);
        } else {
            $accountToSelect = NULL;
        }
    } else {
        if (isset($_POST["otherAccountId"])) {
            $accountToSelect = sanitize_input($_POST["otherAccountId"]);
        } else {
            $accountToSelect = NULL;
        }
    }
    $action = 'SELECT `bank_accounts_ref`.`account_id`, `bank_account`.`balance` FROM `bank_accounts_ref`, `bank_account` WHERE `customer_id` = ? AND 
        `bank_accounts_ref`.`account_id` = `bank_account`.`account_id` ORDER BY `bank_accounts_ref`.`account_id` ASC;';
    $stmt = $connect->prepare($action);
    $stmt->bindParam(1, $_SESSION["customerId"], PDO::PARAM_STR);

    try {
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e) {
        //echo "Retrieve failed: " . $e->getMessage();
    }

    foreach ($result as $row) {
        $accountId = $row["account_id"];
        $balance = $row["balance"];
        $selected = "";
        if ($accountId == $accountToSelect) {
            $selected = "selected";
        }
        echo "
        <option ".$selected." value='".$accountId."'>".$accountId." -Balance: $".$balance."</option>
        ";
    }
}
?>
