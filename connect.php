<?php
	// Database connection variables and credentials
        
	//$config = parse_ini_file('../../private/db-config.ini');
	//$servername = $config['servername'];
	//$username = $config['username'];
	//$password = $config['password'];
	//$dbname = $config['dbname'];
	
	//Temporary variables for development
	$servername = "35.198.206.85"; 
	$username = "sqldev";
	$password = "Ict1004#";
	$dbname = "double_o4_bank";
        
	try {
		$connect = new PDO( "mysql:host=$servername;dbname=$dbname", $username, $password);
		
		$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connect->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		// echo "Connected successfully"; 
	}
	
	catch(PDOException $e) {
		echo "Connection failed: " . $e->getMessage();
	}	
?>