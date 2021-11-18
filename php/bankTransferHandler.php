<?php
    function makeTransaction()
    {
        $customerId = "2";
        $accountId = $otherAccountId = "";
        $accountId = sanitize_input($_POST["transferFromAccountIn"]);
        $otherAccountId = sanitize_input($_POST["transferToAccountIn"]);
        $amountIn = sanitize_input($_POST["transferAmountIn"]);
        $abort = checkValidNum($accountId) + checkValidNum($otherAccountId) + checkValidNum($amountIn);

        include_once "connect.php";

        $action = "SELECT `account_id` from `bank_accounts_ref` where (`account_id` = ? and `customer_id` = ?);";

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

        $fetchedAccountId = $result[0][0];

        $action = "SELECT `account_id`,`balance` from `bank_account` where `account_id` = ?;";

        $stmt = $connect->prepare($action);
        $stmt->bindParam(1, $otherAccountId, PDO::PARAM_STR);

        try {
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e) {
            //echo "Retrieve failed: " . $e->getMessage();
        }

        $fetchedOtherAccountId = $result[0][0];
        $fetchedBalance = $result[0][1];
        if(!$fetchedOtherAccountId||!$fetchedAccountId||$abort||$amountIn <= 0){
            $postdata = http_build_query(
                array(
                    'acountId' => $accountId,
                    'otherAccountId' => $otherAccountId,
                    'amount' => $amountIn,
                    'inputInvalid' => 1
                )
            );
            $opts = array('http' =>
                array(
                    'method' => 'POST',
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $postdata
                )
            );
            $pageName = sanitize_input($_POST["pageName"]);
            $context = stream_context_create($opts);
            $result = file_get_contents($pageName, false, $context);
            echo $result;
            return;
        }
        if( ($fetchedBalance - $amountIn) <= 0){
            $postdata = http_build_query(
                array(
                    'acountId' => $accountId,
                    'otherAccountId' => $otherAccountId,
                    'amount' => $amountIn,
                    'inputInvalid' => 2
                )
            );
            $opts = array('http' =>
                array(
                    'method' => 'POST',
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $postdata
                )
            );
            $pageName = sanitize_input($_POST["pageName"]);
            $context = stream_context_create($opts);
            $result = file_get_contents($pageName, false, $context);
            echo $result;
            return;
        }

        $currentTimestamp = date("Y-m-d h:i:sa");
        //add new transaction data
        $action = "INSERT into `transaction_data`(`credit_id`,`debit_id`,`amount`,`type`,`timestamp`) values (?,?,?,?,?);";
        $stmt = $connect->prepare($action);
        $stmt->bindParam(1, $fetchedOtherAccountId, PDO::PARAM_STR);
        $stmt->bindParam(2, $fetchedAccountId, PDO::PARAM_STR);
        $stmt->bindParam(3, $amountIn, PDO::PARAM_STR);
        $stmt->bindParam(4, "OTRF", PDO::PARAM_STR);
        $stmt->bindParam(5, $currentTimestamp, PDO::PARAM_STR);

        $stmt->execute();

        if(!$stmt->execute())
        {
            $transferErrorPage = file_get_contents("transfer_error.php", false, NULL);
            echo $transferErrorPage;
            return;
        }
        //update destination balance
        $action = "UPDATE `bank_account` set `balance` = `balance` + ? where `account_id` = ?;";
        $stmt = $connect->prepare($action);
        $stmt->bindParam(1, $amountIn, PDO::PARAM_STR);
        $stmt->bindParam(2, $fetchedOtherAccountId, PDO::PARAM_STR);
        
        $stmt->execute();

        if(!$stmt->execute())
        {
            $transferErrorPage = file_get_contents("transfer_error.php", false, NULL);
            echo $transferErrorPage;
            return;
        }
        //update user balance
        $action = "UPDATE `bank_account` set `balance` = `balance` - ? where `account_id` = ?;";
        $stmt = $connect->prepare($action);
        $stmt->bindParam(1, $amountIn, PDO::PARAM_STR);
        $stmt->bindParam(2, $fetchedAccountId, PDO::PARAM_STR);
        
        $stmt->execute();

        if(!$stmt->execute())
        {
            $transferErrorPage = file_get_contents("transfer_error.php", false, NULL);
            echo $transferErrorPage;
            return;
        }

        $_POST["amountIn"] = $amountIn;
        $_POST["otherAccountId"] = $fetchedOtherAccountId;

        $transferSuccessPage = file_get_contents("transfer_success.php", false, NULL);
        echo $transferSuccessPage;

    }
?>