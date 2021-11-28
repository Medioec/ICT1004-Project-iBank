        <?php
        // PDO
//        include_once "connect.php";
//        
//        $query = $conn->prepare("SELECT * FROM user_data WHERE customer_id=?");
//        $stmt = $connect->prepare($query);
//        $stmt->bindParam(1, $customer_id, PDO::PARAM_INT);
//        $stmt->bindParam(2,$fname, PDO::PARAM_STR);
//        $stmt->bindParam(3,$lname, PDO::PARAM_STR);
//        $stmt->bindParam(4,$fullname, PDO::PARAM_STR);
//        $stmt->bindParam(5,$street1, PDO::PARAM_STR);
//        $stmt->bindParam(6,$street2, PDO::PARAM_STR);
//        $stmt->bindParam(7,$postal, PDO::PARAM_STR);
//        $stmt->bindParam(8,$email, PDO::PARAM_STR);
//        $stmt->bindParam(9,$phone, PDO::PARAM_STR);
//        
//        $stmt->execute();
//        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        ?>
        
        <?php
        // MYSQL
        global $fname, $lname, $fullname, $street1, $street2, $postal, $email, $phone, $errorMsg;
        
        // Create database connection.
        $config = parse_ini_file('../../private/db-config.ini');
        $conn = new mysqli($config['servername'], $config['username'],
                $config['password'], $config['dbname']);
        // Prepare the statement:
        $stmt = $conn->prepare("SELECT * FROM user_data WHERE customer_id=?");
        // Hard coded - TODO CHANGE TO SESSION
        //$id = $_SESSION["customerId"];
        $id = 6;
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $fname = $row["first_name"];
            $lname = $row["last_name"];
            $fullname = $row["full_name"];
            $street1 = $row["street1"];
            $street2 = $row["street2"];
            $postal = $row["postal"];
            $email = $row["email"];
            $phone = $row["phone"];
        }
        
        else 
        {
            $errorMsg = "User data not found";
            echo $errorMsg;
        }
        $stmt->close();
        $conn->close();
        ?>
