<?php
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
        if (isset($_SESSION["accountIdIn"])) {
            if($accountId == $_SESSION["accountIdIn"]) {
                $selected = "selected";
            }
        }
        echo "
        <option ".$selected." value='".$accountId."'>".$accountId."</option>
        ";
    }
?>
