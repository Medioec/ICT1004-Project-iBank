<?php
    //Unset all used session variables just in case
    //Remember to set transfer_confirm.php to only be accessible via transfer pages
    if (basename($_SERVER["REQUEST_URI"]) != "transfer_confirm.php") {
        unset($_SESSION["otherAccountId"]);
        unset($_SESSION["accountId"]);
        unset($_SESSION["amountIn"]);
        unset($_SESSION["verified"]);
    }


    function verifyTransaction($connect)
    {
        $logSql = "INSERT INTO `log`(`type`,`category`, `description`, `user_performed`, `timestamp`) VALUES (?,?,?,?,CURRENT_TIMESTAMP)";
        $logType0 = "BANKING";
        $logType1 = "BANKING FAIL";
        $logCategory0 = "INFO";
        $logCategory1 = "WARNING";
        $description = "";

        $customerId = $_SESSION["customerId"];
        $accountId = $otherAccountId = $amountIn = $abort = "";
        $accountId = sanitize_input($_POST["accountId"]);
        $otherAccountId = sanitize_input($_POST["otherAccountId"]);
        $amountIn = sanitize_input($_POST["amountIn"]);
        $abort = checkValidNum($accountId) + checkValidNum($otherAccountId) + checkValidMoney($amountIn);
        if($abort)
        {
            $_SESSION["inputInvalid"] = 1;
            
            //header("Location: ".$_SESSION["originTransactionPage"]);
            return;
        }

        if ($amountIn == 0) {
            $_SESSION["inputInvalid"] = 1;
            $_SESSION["errormsg"] = "Please input a valid amount to transfer.";
            return;
        }

        if ($otherAccountId == $accountId) {
            $_SESSION["inputInvalid"] = 1;
            $_SESSION["errormsg"] = "Please select a different account to transfer to.";
            return;
        }
        //Check that customer owns the selected bank account, balance is valid etc
        $action = "SELECT `account_id`,`balance` FROM `bank_account` WHERE (`account_id` = 
            (select `account_id` FROM `bank_accounts_ref` WHERE (account_id = ? AND customer_id = ?)));";

        $stmt = $connect->prepare($action);
        $stmt->bindParam(1, $accountId, PDO::PARAM_STR);
        $stmt->bindParam(2, $customerId, PDO::PARAM_STR);

        try {
            $success = $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e) {
            //echo "Retrieve failed: " . $e->getMessage();
            $success = 0;
        }

        if(!$success) {
            $_SESSION["sqlFailed"] = 1;
            
            //Create fail log
            $action = $logSql;
            $description = "TRANSFER - SQL FAIL";
            $stmt = $connect->prepare($action);
            $stmt->bindParam(1, $logType1, PDO::PARAM_STR);
            $stmt->bindParam(2, $logCategory1, PDO::PARAM_STR);
            $stmt->bindParam(3, $description, PDO::PARAM_STR);
            $stmt->bindParam(4, $_SESSION["username"], PDO::PARAM_STR);
            try {
                $stmt->execute();
            }
            catch(PDOException $e) {
                //echo "Retrieve failed: " . $e->getMessage();
            }

            header("Location: transfer_error.php");
            return;
        }

        $fetchedAccountId = $result[0]['account_id'];
        $fetchedAccountBalance = $result[0]['balance'];
        //Account does not belong to customer
        if ($fetchedAccountId == null) {
            //Create fail log, possible abuse
            $action = $logSql;
            $description = "TRANSFER - ACCOUNT/USER MISMATCH";
            $stmt = $connect->prepare($action);
            $stmt->bindParam(1, $logType1, PDO::PARAM_STR);
            $stmt->bindParam(2, $logCategory1, PDO::PARAM_STR);
            $stmt->bindParam(3, $description, PDO::PARAM_STR);
            $stmt->bindParam(4, $_SESSION["username"], PDO::PARAM_STR);
            try {
                $stmt->execute();
            }
            catch(PDOException $e) {
                //echo "Retrieve failed: " . $e->getMessage();
            }
            $_SESSION["inputInvalid"] = 1;
            return;
        }

        $action = "SELECT `account_id`,`balance` FROM `bank_account` WHERE `account_id` = ?;";

        $stmt = $connect->prepare($action);
        $stmt->bindParam(1, $otherAccountId, PDO::PARAM_STR);

        try {
            $success = $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e) {
            $success = 0;
        }

        if(!$success) {
            $_SESSION["sqlFailed"] = 1;

            //Create fail log
            $action = $logSql;
            $description = "TRANSFER - SQL FAIL";
            $stmt = $connect->prepare($action);
            $stmt->bindParam(1, $logType1, PDO::PARAM_STR);
            $stmt->bindParam(2, $logCategory1, PDO::PARAM_STR);
            $stmt->bindParam(3, $description, PDO::PARAM_STR);
            $stmt->bindParam(4, $_SESSION["username"], PDO::PARAM_STR);
            try {
                $stmt->execute();
            }
            catch(PDOException $e) {
                //echo "Retrieve failed: " . $e->getMessage();
            }

            header("Location: transfer_error.php");
            return;
        }

        $fetchedOtherAccountId = $result[0]['account_id'];
        //check for problems

        if($fetchedOtherAccountId == null||$abort||($amountIn <= 0) ){

            $_SESSION["inputInvalid"] = 1;
            
            //header("Location: ".$_SESSION["originTransactionPage"]);
            return;
        }

        if( ($fetchedAccountBalance - $amountIn) < 0){
            $_SESSION["inputInvalid"] = 2;
            
            //header("Location: ".$_SESSION["originTransactionPage"]);
            return;
        }

        $_SESSION["otherAccountId"] = $fetchedOtherAccountId;
        $_SESSION["accountId"] = $fetchedAccountId;
        $_SESSION["amountIn"] = $amountIn;
        $_SESSION["verified"] = 1;
        header("Location: transfer_confirm.php");

    }
    function executeTransaction($connect)
    {
        $logSql = "INSERT INTO `log`(`type`,`category`, `description`, `user_performed`, `timestamp`) VALUES (?,?,?,?,CURRENT_TIMESTAMP)";
        $logType1 = "BANKING FAIL";
        $logCategory1 = "WARNING";
        $description = "";

        $fetchedOtherAccountId = $_SESSION["otherAccountId"];
        $fetchedAccountId = $_SESSION["accountId"];
        $amountIn = $_SESSION["amountIn"];
        $currentTimestamp = date("Y-m-d H:i:s");
        $transferType = "OTRF";
        $success = 0;

        //add new transaction data
        $action = "INSERT INTO `transaction_data`(`credit_id`,`debit_id`,`amount`,`type`,`timestamp`) VALUES (?,?,?,?,?);";
        $stmt = $connect->prepare($action);
        $stmt->bindParam(1, $fetchedOtherAccountId, PDO::PARAM_STR);
        $stmt->bindParam(2, $fetchedAccountId, PDO::PARAM_STR);
        $stmt->bindParam(3, $amountIn, PDO::PARAM_STR);
        $stmt->bindParam(4, $transferType, PDO::PARAM_STR);
        $stmt->bindParam(5, $currentTimestamp, PDO::PARAM_STR);

        try {
            $success = $stmt->execute();
        }
        catch(PDOException $e) {
            //echo "Retrieve failed: " . $e->getMessage();
            $success = 0;
        }

        if ($connect->lastInsertId() == NULL||!$success) {
            $_SESSION["sqlFailed"] = 1;
            //Create fail log
            $action = $logSql;
            $description = "TRANSFER - SQL FAIL";
            $stmt = $connect->prepare($action);
            $stmt->bindParam(1, $logType1, PDO::PARAM_STR);
            $stmt->bindParam(2, $logCategory1, PDO::PARAM_STR);
            $stmt->bindParam(3, $description, PDO::PARAM_STR);
            $stmt->bindParam(4, $_SESSION["username"], PDO::PARAM_STR);
            try {
                $stmt->execute();
            }
            catch(PDOException $e) {
                //echo "Retrieve failed: " . $e->getMessage();
            }

            header("Location: transfer_error.php");
            return;
        }

        //update destination balance
        $action = "UPDATE `bank_account` SET `balance` = `balance` + ? WHERE `account_id` = ?;";
        $stmt = $connect->prepare($action);
        $stmt->bindParam(1, $amountIn, PDO::PARAM_STR);
        $stmt->bindParam(2, $fetchedOtherAccountId, PDO::PARAM_STR);
        $success = 0;
        
        try {
            $success = $stmt->execute();
        }
        catch(PDOException $e) {
            //echo "Retrieve failed: " . $e->getMessage();
            $success = 0;
        }

        if (!$success) {
            $_SESSION["sqlFailed"] = 1;
            //Create fail log
            $action = $logSql;
            $description = "TRANSFER - SQL FAIL, TABLE MISMATCH";
            $stmt = $connect->prepare($action);
            $stmt->bindParam(1, $logType1, PDO::PARAM_STR);
            $stmt->bindParam(2, $logCategory1, PDO::PARAM_STR);
            $stmt->bindParam(3, $description, PDO::PARAM_STR);
            $stmt->bindParam(4, $_SESSION["username"], PDO::PARAM_STR);
            try {
                $stmt->execute();
            }
            catch(PDOException $e) {
                //echo "Retrieve failed: " . $e->getMessage();
            }
            header("Location: transfer_error.php");
            return;
        }

        //update user balance
        $action = "UPDATE `bank_account` SET `balance` = `balance` - ? WHERE `account_id` = ?;";
        $stmt = $connect->prepare($action);
        $stmt->bindParam(1, $amountIn, PDO::PARAM_STR);
        $stmt->bindParam(2, $fetchedAccountId, PDO::PARAM_STR);
        $success = 0;
        
        try {
            $success = $stmt->execute();
        }
        catch(PDOException $e) {
            //echo "Retrieve failed: " . $e->getMessage();
            $success = 0;
        }

        if (!$success) {
            $_SESSION["sqlFailed"] = 1;
            //Create fail log
            $action = $logSql;
            $description = "TRANSFER - SQL FAIL, TABLE MISMATCH";
            $stmt = $connect->prepare($action);
            $stmt->bindParam(1, $logType1, PDO::PARAM_STR);
            $stmt->bindParam(2, $logCategory1, PDO::PARAM_STR);
            $stmt->bindParam(3, $description, PDO::PARAM_STR);
            $stmt->bindParam(4, $_SESSION["username"], PDO::PARAM_STR);
            try {
                $stmt->execute();
            }
            catch(PDOException $e) {
                //echo "Retrieve failed: " . $e->getMessage();
            }
            header("Location: transfer_error.php");
            return;
        }

        $_SESSION["amountIn"] = $amountIn;
        $_SESSION["otherAccountIn"] = $fetchedOtherAccountId;
        $_SESSION["transferSuccess"] = 1;

        header("Location: transfer_success.php");
    }
?>
