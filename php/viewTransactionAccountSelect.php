<?php
    include_once "php/connect.php";
    include_once "php/inputCheckHandler.php";

    //temporary testing without login
    $session_user = "test";
    if (!isset($_SESSION['customer_id'])) {
        $action = 'SELECT `customer_id` FROM `customer_credentials` WHERE `customer_username` = ?;';
        $stmt = $connect->prepare($action);
        $stmt->bindParam(1, $session_user, PDO::PARAM_STR);
        try {
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e) {
            //echo "Retrieve failed: " . $e->getMessage();
        }
        $_SESSION["customerId"] = $result[0]['customer_id'];
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
