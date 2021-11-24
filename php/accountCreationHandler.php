<?php
function createAccount($connect) {
    $accountType = sanitize_input($_POST["createType"]);
    $valid = $accountType == "Savings"||$accountType == "Checking";
    $success = 1;
    if ($valid) {
        $action = "INSERT INTO `bank_account`(`type`, `balance`) VALUES (?, 0);";
        $stmt = $connect->prepare($action);
        $stmt->bindParam(1, $accountType, PDO::PARAM_STR);
        try {
            $stmt->execute();
        }
        catch(PDOException $e) {
            //echo "Retrieve failed: " . $e->getMessage();
            $success = 0;
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
                $stmt->execute();
            }
            catch(PDOException $e) {
                //echo "Retrieve failed: " . $e->getMessage();
                $success = 0;
                $_SESSION["sqlFailed"] = 1;
                header("Location: request_error.php");
            }

        }
        if ($success) {
            $_SESSION["sqlSuccess"] = 1;
            $_SESSION["newAccountType"] = $accountType;
            $_SESSION["newAccountId"] = $newAccountId;
            header("Location: accounts_create_success.php");
        }
    }
}
?>
