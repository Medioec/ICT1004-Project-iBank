<?php
    $_SESSION["customerId"] = 2; //temporary session var to remove when login is done
    function getBalance()
    {   
        $customerId = $_SESSION["customerId"];

        include_once "connect.php";
        include_once "balanceDatatable.php";
        
        $action = "SELECT * FROM `bank_account` 
            WHERE `account_id` IN
            (select `account_id` from `bank_accounts_ref` where `customer_id` = ?);";
        
        $stmt = $connect->prepare($action);
        $stmt->bindParam(1,$customerId, PDO::PARAM_INT);
        
        try {
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        }
        catch(PDOException $e) {
            //echo "Retrieve failed: " . $e->getMessage();
        }
        formBalanceTable($result);
    }
    getBalance();
?>