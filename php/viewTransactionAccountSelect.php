<?php
    include_once "php/connect.php";
    include_once "php/inputCheckHandler.php";

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
        $accountIdIn = sanitize_input($_POST["accountIn"]);
        if ($accountIdIn != NULL) {
            if($accountId == $accountIdIn) {
                $selected = "selected";
                $accountIdIn = NULL;
            }
        }
        echo "
        <option ".$selected." value='".$accountId."'>".$accountId."</option>
        ";
    }
?>
