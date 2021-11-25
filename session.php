<?php
        //define('ROOTPATH', $_SERVER['DOCUMENT_ROOT']);
        //set_include_path(ROOTPATH);
	include_once ('php/connect.php');
	session_start();
	
	$dbsuccess = false;
	
	if (isset($_SESSION['username'])) {
		$session_user = $_SESSION['username'];
	}
   
	$session_sql = "SELECT `active` FROM `customer_credentials` WHERE `customer_username` = ?";
	$session_statement = $connect->prepare($session_sql);
	$session_statement->bindParam(1,$session_user,PDO::PARAM_STR);
	
	try {
		$session_statement->execute();
		$getActive = $session_statement->fetchAll(PDO::FETCH_ASSOC);
		$dbsuccess = true;
		$isActive = $getActive[0]['active'];
	}
	catch (PDOException $e) {
		$dbsuccess = false;
	}
	
	if(($_SESSION['loggedin']!="1") || ($isActive=="0") || (!isset($isActive)) || ($_SESSION['otp']!="1")){
		$_SESSION['loggedin']="0";
		header("location: login.php");
    }

	echo "<html oncontextmenu=\"return false\">";
?>
