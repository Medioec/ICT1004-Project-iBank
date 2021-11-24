<?php
    function getBalance($connect)
    {   
        $customerId = $_SESSION["customerId"];
        
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
        if ($result) {
            formBalanceTable($result);
        } else {
            echo '
            <p>An error has occured in displaying this data. Please try again later.</p>
            ';
        }
    }
?>
