<?php
    function getTransaction($connect)
    {
        $accountId = $fromDate = $toDate = "";
        $accountId = sanitize_input($_POST["accountId"]);
        $fromDate = sanitize_input($_POST["fromDateIn"]);
        $toDate = sanitize_input($_POST["toDateIn"]);

        $action = "SELECT `account_id` FROM `bank_accounts_ref` WHERE (`account_id` = ? AND `customer_id` = ?);";

        $stmt = $connect->prepare($action);
        $stmt->bindParam(1, $accountId, PDO::PARAM_INT);
        $stmt->bindParam(2, $_SESSION["customerId"], PDO::PARAM_INT);

        try {
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e) {
            echo "Retrieve failed: " . $e->getMessage();
        }

        if ($result[0]["account_id"] != NULL) {
            $fetchedAccountId = $result[0]["account_id"];
        } else {
            $_SESSION["inputInvalid"] = 1;
            echo"";
            return;
        }
        
        if(!$toDate){$toDate = date("Y-m-d H:i:s");}
        if(!$fromDate){$fromDate = date("Y-m-d", strtotime("-1 month"));}
        $abort = checkValidNum($accountId) + checkValidNum($fromDate) + checkValidNum($toDate);
        if($abort){
            $_SESSION["inputInvalid"] = 1;
            return;
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
        }
        catch(PDOException $e) {
            echo "Retrieve failed: " . $e->getMessage();
        }
        // function in transactionDatatable.php
        formTransactionTable($result, $accountId);
    }
?>
