<?php
	// Database connection variables and credentials
        
	$config = parse_ini_file('/var/www/private/db-config.ini');
	$servername = $config['servername'];
	$username = $config['username'];
	$password = $config['password'];
	$dbname = $config['dbname']; // In db-config.ini [dbname = "double_o4_bank"]
	try {
		$connect = new PDO( "mysql:host=$servername;dbname=$dbname", $username, $password);
		
		$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connect->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		//echo "Connected successfully php"; 
	}
	
	catch(PDOException $e) {
		echo "Connection failed php: " . $e->getMessage();
	}	
?>