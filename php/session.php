<?php
	
	require_once ('connect.php');
	
	session_start();
	
	//Session vars username customerId

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
		//temporary disable;
		//header("location:login.php");
    }

	echo "<html oncontextmenu=\"return false\">";

	//temporary testing without login
	$session_user = "test";
	if (!isset($_SESSION['customer_id'])) {
		$action = 'SELECT `customer_id` FROM `customer_credentials` WHERE `customer_username` = ?;';
		$stmt = $connect->prepare($action);
		$stmt->bindParam(1, $session_user, PDO::PARAM_STR);
		try {
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e) {
			//echo "Retrieve failed: " . $e->getMessage();
		}
		$_SESSION["customerId"] = $result[0]['customer_id'];
	}

?>
