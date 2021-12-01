<?php

    // PDO
    global $fname, $lname, $fullname, $street1, $street2, $postal, $email, $phone, $errorMsg;

    include_once "php/connect.php";

    $query = "SELECT * FROM user_data WHERE customer_id=?";
    $stmt = $connect->prepare($query);
    $id = $_SESSION["customerId"];
    $stmt->bindParam(1, $id, PDO::PARAM_INT);

    try {
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    } 
    catch (PDOException $e) {
        $errorMsg = "User data not found";
        echo $errorMsg;
    }

    foreach ($result as $row) {
        $fname = htmlentities($row["first_name"]);
        $lname = htmlentities($row["last_name"]);
        $fullname = htmlentities($row["full_name"]);
        $street1 = htmlentities($row["street1"]);
        $street2 = htmlentities($row["street2"]);
        $postal = htmlentities($row["postal"]);
        $email = htmlentities($row["email"]);
        $current_email = htmlentities($row["email"]);
        $phone = htmlentities($row["phone"]);
    }
?>

<?php

// MYSQL
//        global $fname, $lname, $fullname, $street1, $street2, $postal, $email, $phone, $errorMsg;
//        
//        // Create database connection.
//        $config = parse_ini_file('../../private/db-config.ini');
//        $conn = new mysqli($config['servername'], $config['username'],
//                $config['password'], $config['dbname']);
//        // Prepare the statement:
//        $stmt = $conn->prepare("SELECT * FROM user_data WHERE customer_id=?");
//        // Hard coded - TODO CHANGE TO SESSION
//        $id = $_SESSION["customerId"];
//        //$id = 6;
//        $stmt->bind_param("s", $id);
//        $stmt->execute();
//        $result = $stmt->get_result();
//        
//        if ($result->num_rows > 0) {
//            $row = $result->fetch_assoc();
//            $fname = htmlentities($row["first_name"]);
//            $lname = htmlentities($row["last_name"]);
//            $fullname = htmlentities($row["full_name"]);
//            $street1 = htmlentities($row["street1"]);
//            $street2 = htmlentities($row["street2"]);
//            $postal = htmlentities($row["postal"]);
//            $email = htmlentities($row["email"]);
//            $phone = htmlentities($row["phone"]);
//        }
//        
//        else 
//        {
//            $errorMsg = "User data not found";
//            echo $errorMsg;
//        }
//        $stmt->close();
//        $conn->close();
?>
