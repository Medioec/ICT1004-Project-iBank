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
    $action = 'SELECT `account_id` FROM `bank_accounts_ref` WHERE `customer_id` = ? ORDER BY `account_id` ASC;';
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
        $selected = "";
        if ($accountId == $accountToSelect) {
            $selected = "selected";
        }
        echo "
        <option ".$selected." value='".$accountId."'>".$accountId."</option>
        ";
    }
}
?>
