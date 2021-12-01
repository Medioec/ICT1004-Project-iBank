<?php
include "staff_session.php";
include_once 'connect.php';

$logSql = "SELECT `type`, `category`, `description`, `user_performed`, `timestamp` FROM `log` WHERE `deleted` = 0";
$logStmt = $connect->prepare($logSql);
$logStmt->bindParam(1,$session_user, PDO::PARAM_STR);
$logStmt->execute();
$logResult = $logStmt->fetchAll(PDO::FETCH_ASSOC);

$logResult = filter_var_array($logResult, FILTER_SANITIZE_STRING);

echo json_encode($logResult);
?>