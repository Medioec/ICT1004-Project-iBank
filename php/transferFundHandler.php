<?php
    include_once "php/inputCheckHandler.php";

    $confirmTransfer = 0;
    if(isset($_POST["confirmTransfer"])) {
        if ($_POST["confirmTransfer"]) {
            $confirmTransfer = 1;
        }
    }
    $toVerify = 0;
    if(isset($_POST["verifyTransfer"])) {
        if ($_POST["verifyTransfer"]) {
            $toVerify = 1;
        }
    }

    if ($confirmTransfer)
    {
        executeTransaction();
	}
    else if ($toVerify)
    {
        verifyTransaction();
    }

    function verifyTransaction()
    {
        $customerId = $_SESSION["customerId"];
        $accountId = $otherAccountId = $amountIn = $abort = "";
        $accountId = sanitize_input($_POST["transferFromAccountIn"]);
        $otherAccountId = sanitize_input($_POST["transferToAccountIn"]);
        $amountIn = sanitize_input($_POST["transferAmountIn"]);
        $abort = checkValidNum($accountId) + checkValidNum($otherAccountId) + checkValidMoney($amountIn);
        $_SESSION["accountId"] = $accountId;
        $_SESSION["otherAccountId"] = $otherAccountId;
        $_SESSION["amountIn"] = $amountIn;
        if($abort)
        {
            $_SESSION["inputInvalid"] = 1;
            
            //header("Location: ".$_SESSION["originTransactionPage"]);
            return;
        }

        include_once "connect.php";

        $action = "SELECT `account_id`,`balance` FROM `bank_account` WHERE (`account_id` = 
            (select `account_id` FROM `bank_accounts_ref` WHERE (account_id = ? AND customer_id = ?)));";

        $stmt = $connect->prepare($action);
        $stmt->bindParam(1, $accountId, PDO::PARAM_STR);
        $stmt->bindParam(2, $customerId, PDO::PARAM_STR);

        try {
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e) {
            //echo "Retrieve failed: " . $e->getMessage();
        }

        $fetchedAccountId = $result[0]['account_id'];
        $fetchedAccountBalance = $result[0]['balance'];

        $action = "SELECT `account_id`,`balance` FROM `bank_account` WHERE `account_id` = ?;";

        $stmt = $connect->prepare($action);
        $stmt->bindParam(1, $otherAccountId, PDO::PARAM_STR);

        try {
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e) {
            echo "Retrieve failed: " . $e->getMessage();
        }

        $fetchedOtherAccountId = $result[0]['account_id'];
        $fetchedOtherAccountBalance = $result[0]['balance'];
        //check for problems
        if($fetchedOtherAccountId == null||$fetchedAccountId == null||$abort||($amountIn <= 0) ){

            $_SESSION["inputInvalid"] = 1;
            
            //header("Location: ".$_SESSION["originTransactionPage"]);
            return;
        }

        if( ($fetchedAccountBalance - $amountIn) <= 0){
            $_SESSION["inputInvalid"] = 2;
            
            //header("Location: ".$_SESSION["originTransactionPage"]);
            return;
        }

        $_SESSION["fetchedOtherAccountId"] = $fetchedOtherAccountId;
        $_SESSION["fetchedAccountId"] = $fetchedAccountId;
        $_SESSION["amountIn"] = $amountIn;
        $_SESSION["transferInputVerified"] = 1;
        header("Location: transfer_confirm.php");

    }
    function executeTransaction()
    {
        include_once "connect.php";
        $fetchedOtherAccountId = $_SESSION["fetchedOtherAccountId"];
        $fetchedAccountId = $_SESSION["fetchedAccountId"];
        $amountIn = $_SESSION["amountIn"];
        $currentTimestamp = date("Y-m-d H:i:s");
        $transferType = "OTRF";

        //add new transaction data
        $action = "INSERT INTO `transaction_data`(`credit_id`,`debit_id`,`amount`,`type`,`timestamp`) VALUES (?,?,?,?,?);";
        $stmt = $connect->prepare($action);
        $stmt->bindParam(1, $fetchedOtherAccountId, PDO::PARAM_STR);
        $stmt->bindParam(2, $fetchedAccountId, PDO::PARAM_STR);
        $stmt->bindParam(3, $amountIn, PDO::PARAM_STR);
        $stmt->bindParam(4, $transferType, PDO::PARAM_STR);
        $stmt->bindParam(5, $currentTimestamp, PDO::PARAM_STR);

        try {
            $stmt->execute();
        }
        catch(PDOException $e) {
            //echo "Retrieve failed: " . $e->getMessage();
            header("Location: transfer_error.php");
            return;
        }

        //update destination balance
        $action = "UPDATE `bank_account` SET `balance` = `balance` + ? WHERE `account_id` = ?;";
        $stmt = $connect->prepare($action);
        $stmt->bindParam(1, $amountIn, PDO::PARAM_STR);
        $stmt->bindParam(2, $fetchedOtherAccountId, PDO::PARAM_STR);
        
        try {
            $stmt->execute();
        }
        catch(PDOException $e) {
            //echo "Retrieve failed: " . $e->getMessage();
            header("Location: transfer_error.php");
            return;
        }
        //update user balance
        $action = "UPDATE `bank_account` SET `balance` = `balance` - ? WHERE `account_id` = ?;";
        $stmt = $connect->prepare($action);
        $stmt->bindParam(1, $amountIn, PDO::PARAM_STR);
        $stmt->bindParam(2, $fetchedAccountId, PDO::PARAM_STR);
        
        try {
            $stmt->execute();
        }
        catch(PDOException $e) {
            //echo "Retrieve failed: " . $e->getMessage();
            header("Location: transfer_error.php");
            return;
        }

        $_SESSION["amountIn"] = $amountIn;
        $_SESSION["otherAccountId"] = $fetchedOtherAccountId;
        //$_SESSION["transferInputVerified"] = 0;

        header("Location: transfer_success.php");
    }
?>