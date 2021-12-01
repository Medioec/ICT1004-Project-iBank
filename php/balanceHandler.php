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
            $success = $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        }
        catch(PDOException $e) {
            //echo "Retrieve failed: " . $e->getMessage();
            $success = 0;
        }

        if(!$success) {
            echo '
            <p>An error has occured in displaying this data. Please try again later.</p>
            ';
            return;
        }

        if ($result) {
            formBalanceTable($result);
        } else {
            echo '
            <p>You do not have any accounts. Create an account <a href="accounts_create.php">here</a></p>
            ';
        }
    }
?>
