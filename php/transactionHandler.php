<?php
    include "php/inputCheckHandler.php";
    $accountId = $fromDate = $toDate = "";
    $accountId = sanitize_input($_POST["accountIn"]);
    $fromDate = sanitize_input($_POST["fromDateIn"]);
    $toDate = sanitize_input($_POST["toDateIn"]);
    $abort = checkValidNum($accountId) + checkValidNum($fromDate) + checkValidNum($toDate);
    if(!$accountId){$accountId = -1;}
    if(!$toDate){$toDate = date("Y-m-d");}
    if(!$fromDate){$fromDate = date("Y-m-d");}

    function getTransaction($accountId, $fromDate, $toDate, $abort)
    {   
        echo $fromDate;
        if($abort){ return;}
        include_once "connect.php";
        include_once "transactionDatatable.php";
        
        $action = "SELECT * FROM `transaction_data` WHERE 
            (`credit_id` = $accountId OR `debit_id` = $accountId)
            AND (`timestamp` BETWEEN ? AND ?);";
        
        $stmt = $connect->prepare($action);
        $stmt->bindParam(1,$fromDate, PDO::PARAM_STR);
        $stmt->bindParam(2,$toDate, PDO::PARAM_STR);
        
        try {
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        }
        catch(PDOException $e) {
            echo "Retrieve failed: " . $e->getMessage();
        }
        formTransactionTable($result, $accountId);
    }
    getTransaction($accountId, $fromDate, $toDate, $abort);
?>