<?php
function createAccount($connect) {

    $logSql = "INSERT INTO `log`(`type`,`category`, `description`, `user_performed`, `timestamp`) VALUES (?,?,?,?,CURRENT_TIMESTAMP)";
    $logType0 = "BANKING";
    $logType1 = "BANKING FAIL";
    $logCategory0 = "INFO";
    $logCategory1 = "WARNING";
    $description = "";
    $table1InsertFail = 0;
    $table2InsertFail = 0;

    $accountType = sanitize_input($_POST["createType"]);
    $valid = $accountType == "Savings"||$accountType == "Checking";
    $success = 1;
    if ($valid) {
        $action = "INSERT INTO `bank_account`(`type`, `balance`) VALUES (?, 0);";
        $stmt = $connect->prepare($action);
        $stmt->bindParam(1, $accountType, PDO::PARAM_STR);
        try {
            $success = $stmt->execute();
        }
        catch(PDOException $e) {
            //echo "Retrieve failed: " . $e->getMessage();
            $success = 0;
        }

        if (!$success) {
            $table1InsertFail = 1;
            $_SESSION["sqlFailed"] = 1;
            header("Location: request_error.php");
        }

        if ($success) {
            $newAccountId = $connect->lastInsertId();
            $action = "INSERT INTO `bank_accounts_ref`(`customer_id`,`account_id`) VALUES (?,?);";
            $stmt = $connect->prepare($action);
            $stmt->bindParam(1, $_SESSION["customerId"], PDO::PARAM_INT);
            $stmt->bindParam(2, $newAccountId, PDO::PARAM_STR);

            try {
                $success = $stmt->execute();
            }
            catch(PDOException $e) {
                //echo "Retrieve failed: " . $e->getMessage();
                $success = 0;
            }

            if (!$success) {
                $table2InsertFail = 1;
                $_SESSION["sqlFailed"] = 1;
                header("Location: request_error.php");
            }

            if ($table2InsertFail && !$table1InsertFail) {
                //Create fail log
                $action = $logSql;
                $description = "SQL FAILURE (Please escalate to db admin)";
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
            }

        }
        if ($success) {
            //Create success log
            $action = $logSql;
            $description = "BANK ACCOUNT ".$newAccountId." CREATED";
            $stmt = $connect->prepare($action);
            $stmt->bindParam(1, $logType0, PDO::PARAM_STR);
            $stmt->bindParam(2, $logCategory0, PDO::PARAM_STR);
            $stmt->bindParam(3, $description, PDO::PARAM_STR);
            $stmt->bindParam(4, $_SESSION["username"], PDO::PARAM_STR);
            try {
                $stmt->execute();
            }
            catch(PDOException $e) {
                //echo "Retrieve failed: " . $e->getMessage();
            }

            $_SESSION["sqlSuccess"] = 1;
            $_SESSION["newAccountType"] = $accountType;
            $_SESSION["newAccountId"] = $newAccountId;
            header("Location: accounts_create_success.php");
        }
    } else {
        $_SESSION["inputInvalid"] = 1;
        //Create fail log
        $action = $logSql;
        $description = "ACCOUNT CREATE - INVALID TYPE SELECTED";
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
    }
}
?>
