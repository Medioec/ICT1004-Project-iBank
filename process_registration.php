<?php 
ob_start(); 
?>
<html>
    <head>
        <?php
        include "head.inc.php";
        ?>
    </head>
    <body>
        <?php
        include "nav.inc.php";
        ?>  
        <div class="page-bg"></div>
            <main class="page-body">
                <div class="page-content">
                    <div class="main-content">

                <?php
                // IF REQUEST METHOD IS POST, NOT GET
                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    // Initialize variables
                    $errorMsg = "";
                    $success = true;

                    // FIRST NAME VALIDATION AND SANITIZATION (Nullable)
                    if (!empty($_POST["fname"])) {
                        $fname = sanitize_input($_POST["fname"]);
                        $fname = htmlentities($_POST["fname"]);
                        if (!filter_var($fname, FILTER_SANITIZE_STRING)) {
                        $errorMsg .= "Invalid Name format.<br>";
                        $success = false;
                    }
                    }

                    // LAST NAME VALIDATION AND SANITIZATION (Required)
                    if (empty($_POST["lname"])) {
                        $errorMsg .= "Last Name is required.<br>";
                        $success = false;
                    } else {
                        // Additional check on last name field.
                        $lname = sanitize_input($_POST["lname"]);
                        $lname = htmlentities($_POST["lname"]);
                        if (!filter_var($lname, FILTER_SANITIZE_STRING)) {
                            $errorMsg .= "Invalid Name format.<br>";
                            $success = false;
                        }
                    }

                    // FULL NAME VALIDATION AND SANITIZATION (Required)
                    if (empty($_POST["fullname"])) {
                        $errorMsg .= "Full Name is required.<br>";
                        $success = false;
                    } else {
                        // Additional check on last name field.
                        $fullname = sanitize_input($_POST["fullname"]);
                        $fullname = htmlentities($_POST["fullname"]);
                        if (!filter_var($fullname, FILTER_SANITIZE_STRING)) {
                            $errorMsg .= "Invalid Name format.<br>";
                            $success = false;
                        }
                    }
                    
                    // NRIC VALIDATION AND SANITIZATION (Required)
                    if (empty($_POST["nric"])) {
                        $errorMsg .= "NRIC / Passport No. is required.<br>";
                        $success = false;
                    } else {
                        // Additional check on last name field.
                        $nric = sanitize_input($_POST["nric"]);
                        
                        if(!preg_match('/^[A-Za-z]{1}[0-9]{7}[A-Za-z]{1}$/', $nric)){
                            $errorMsg .= "Invalid NRIC / Password No.<br>";
                            $success = false;
                        }  
                    }
                    
                    // NRIC VALIDATION AND SANITIZATION (Required)
                    if (empty($_POST["dob"])) {
                        $errorMsg .= "Date of Birth is required.<br>";
                        $success = false;
                    } else {
                        // Additional check on last name field.
                        $dob = sanitize_input($_POST["dob"]);
                        
                        if(!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $dob)){
                            $errorMsg .= "Invalid Date of Birth.<br>";
                            $success = false;
                        }  
                    }
                    
                    // NRIC VALIDATION AND SANITIZATION (Required)
                    if (empty($_POST["gender"])) {
                        $errorMsg .= "Gender is required.<br>";
                        $success = false;
                    } else {
                        // Additional check on last name field.
                        $gender = sanitize_input($_POST["gender"]);
                    }  

                    // STREET1 VALIDATION AND SANITIZATION, CONSIDER CHANGING TO POSTAL API (Required)
                    if (empty($_POST["street1"])) {
                        $errorMsg .= "Street1 is required.<br>";
                        $success = false;
                    } else {
                        // Additional check on last name field.
                        $street1 = sanitize_input($_POST["street1"]);
                        $street1 = htmlentities($_POST["street1"]);
                        if (!filter_var($street1, FILTER_SANITIZE_STRING)) {
                            $errorMsg .= "Invalid Street Name.<br>";
                            $success = false;
                        }
                    }

                    // STREET2 VALIDATION AND SANITIZATION, CONSIDER CHANGING TO POSTAL API (Nullable)
                    if (!empty($_POST["street2"])){
                        $street2 = sanitize_input($_POST["street2"]);
                        $street2 = htmlentities($_POST["street2"]);
                        if (!filter_var($street2, FILTER_SANITIZE_STRING)) {
                        $errorMsg .= "Invalid Street Name.<br>";
                        $success = false;
                    }
                    }

                    // POSTAL CODE VALIDATION AND SANITIZATION (Required)
                    if (empty($_POST["postal"])) {
                        $errorMsg .= "Postal Code is required.<br>";
                        $success = false;
                    } else {
                        // Additional check on last name field.
                        $postal = sanitize_input($_POST["postal"]);
                        if (!filter_var($postal, FILTER_SANITIZE_STRING)) {
                            $errorMsg .= "Invalid Postal Code.<br>";
                            $success = false;
                        }
                    }

                    // EMAIL VALIDATION AND SANITIZATION (Required)
                    if (empty($_POST["email"])) {
                        $errorMsg .= "Email is required.<br>";
                        $success = false;
                    } else {
                        $email = sanitize_input($_POST["email"]);
                        // VALIDATING USING REGEX
                        $emailregex = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
                        if (!preg_match($emailregex, $email)) {
                            $errorMsg .= "Invalid email format.<br>";
                            $success = false;
                        } else {
                            checkEmailExist();
                        }
                    }

                    // PHONE NO. VALIDATION AND SANITIZATION (Required)
                    if (empty($_POST["phone"])) {
                        $errorMsg .= "Phone Number is required.<br>";
                        $success = false;
                    } else {
                        // Additional check on last name field.
                        $phone = sanitize_input($_POST["phone"]);
                        if (!filter_var($phone, FILTER_SANITIZE_STRING)) {
                            $errorMsg .= "Invalid Phone Number.<br>";
                            $success = false;
                        }
                    }
                    
                    
                    // USERNAME VALIDATION AND SANITIZATION (Required)
                    if (empty($_POST["username"])) {
                        $errorMsg .= "Username is required.<br>";
                        $success = false;
                    } else {
                        // Additional check on last name field.
                        $username = sanitize_input($_POST["username"]);
                        
                        if(!preg_match('/^[A-Za-z][A-Za-z0-9]{5,31}$/', $username)){
                            $errorMsg .= "Username should contain only alphanumeric characters, length 5-30.<br>";
                            $success = false;
                        }
                        else{
                            checkUsernameExist();
                        }
                    }

                    // PASSWORD VALIDATION FOR CURRENT PASWWORD (Required)
                    if (empty($_POST['pwd'])) {
                        $errorMsg .= "Please set a password for your account.<br>";
                        $success = false;
                    }
                    // VALIDATING USING REGEX
                    else {
                        if (strlen($_POST['pwd']) < '12') {
                            $errorMsg .= "Password Must Contain At Least 12 Characters!<br>";
                            $success = false;
                        } elseif (!preg_match("#[0-9]+#", $_POST["pwd"])) {
                            $errorMsg .= "Password Must Contain At Least 1 Number!<br>";
                            $success = false;
                        } elseif (!preg_match("#[A-Z]+#", $_POST["pwd"])) {
                            $errorMsg .= "Password Must Contain At Least 1 Capital Letter!<br>";
                            $success = false;
                        } elseif (!preg_match("#[a-z]+#", $_POST["pwd"])) {
                            $errorMsg .= "Password Must Contain At Least 1 Lowercase Letter!<br>";
                            $success = false;
                        } elseif ($_POST['pwd'] !== $_POST['cfm_pwd']) {
                            $errorMsg .= "Password Does Not Match!<br>";
                            $success = false;
                        }
                        // IF Passed REGEX validation, Cross check with DB for current password
                        else {
                            // HASH THE PASSWORD and check if it matches password in DB
                            $pwd_hashed = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
                        }
                    }


                    // If Success, Insert information into DB
                    if ($success) {
                        registerUser();
                        
                        // Send confirmation email
                        include_once ('php/sendmail.php');
                        phpMailerRegistration($_POST["email"], $_POST["lname"]);
                        
                        echo "<h2>Registration Successful!</h2><br>";
                        echo "<h4>" . $_POST["lname"] . ", you're now a member of Double04 Bank <i class='bi bi-emoji-sunglasses'></i></h4><br>";
                        // TO-DO Implement PHP mail to send success registration email
                        echo "<div class='alert alert-success' role='alert'> A confirmation email has been sent to ". $_POST["email"]. "</div>";
                        //date_default_timezone_set('Asia/Singapore');
                        //echo "<h5>" . date("Y/m/d") . " " . date("h:i:sa") . "</h5><br>";
                        echo "<p>Redirecting back to Login page. Click on the button if the page does not redirect.</p>";
                        echo "<button onclick='goHome()' class='btn btn-success'>Login</button>";
                        echo "<br><br><br><br><br><br><br><br>";
                        header('Refresh: 3; URL=login.php');
                    }
                    // Else, show unsuccessful messages
                    else {
                        echo "<h2><i class='bi bi-exclamation-square'></i> Registration Unsuccessful</h2>";
                        echo "<h4>The following errors were detected:</h4>";
                        echo "<p style='color:red'>". $errorMsg . "</p>";
                        echo "<p><button onclick='goBack()' class='btn btn-primary'>Return to update details</button></p>";
                        echo "<br><br><br><br><br><br><br><br>";
                    }
                    
                }    

                // If user try to navigate using direct URL (This process is a POST method) 2nd Layer - 1st layer Session set.
                else {
                    echo "<h3>Error</h3>";
                    echo "<br><br><br><br><br><br><br><br>";
                }

                //Helper function that checks input for malicious or unwanted content.
                function sanitize_input($data) {
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = htmlspecialchars($data);
                    $data = htmlentities($data);
                    return $data;
                }
                ?>
            </div>


            <?php
            // Function to check if email has been used
            function checkEmailExist() {
                global $email, $errorMsg, $success;

                // Create database connection.
                $config = parse_ini_file('../../private/db-config.ini');
                $conn = new mysqli($config['servername'], $config['username'],
                        $config['password'], $config['dbname']);

                // Check connection
                if ($conn->connect_error) {
                    $errorMsg = "Connection failed: " . $conn->connect_error;
                    $success = false;
                } else {
                    $stmt = $conn->prepare("SELECT * FROM user_data WHERE email=?");
                    $email = $_POST["email"];
                    $stmt->bind_param("s", $email);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        $errorMsg .= "This email has been registered.<br>";
                        $success = false;
                    }
                    $stmt->close();
                }
                $conn->close();
            }
            ?>
            
            
            
            <?php

            // Function to check if username has been used
            function checkUsernameExist() {
                global $username, $errorMsg, $success;

                // Create database connection.
                $config = parse_ini_file('../../private/db-config.ini');
                $conn = new mysqli($config['servername'], $config['username'],
                        $config['password'], $config['dbname']);

                // Check connection
                if ($conn->connect_error) {
                    $errorMsg = "Connection failed: " . $conn->connect_error;
                    $success = false;
                } else {
                    $stmt = $conn->prepare("SELECT * FROM customer_credentials WHERE customer_username=?");
                    $username = $_POST["username"];
                    $stmt->bind_param("s", $username);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        $errorMsg .= "Username has been taken, Please select another username.<br>";
                        $success = false;
                    }
                    $stmt->close();
                }
                $conn->close();
            }
            ?>
            <?php

            // Function to register user into DB
            function registerUser() {
                global $username, $pwd_hashed, $fname, $lname, $fullname, $street1, $street2, $postal, $email, $phone, $nric, $gender, $dob, $errorMsg, $success;
                
                // TODO - CHANGE TO PDO
                $config = parse_ini_file('../../private/db-config.ini');
                $conn = new mysqli($config['servername'], $config['username'],
                        $config['password'], $config['dbname']);
                // Check connection
                if ($conn->connect_error) {
                    $errorMsg = "Connection failed: " . $conn->connect_error;
                    $success = false;
                }

                else {
                    // Insert into customer_credentials table
                    $stmtCredential = $conn->prepare("INSERT INTO customer_credentials (customer_username, password_hash, otp, password_token, active) VALUES (?,?,?,?,?)");

                    $otp = "12345";
                    $rndno = rand(1, 9999999);
                    $token = md5($rndno);
                    $active = 1;
                    $stmtCredential->bind_param("sssss", $username, $pwd_hashed, $otp, $token, $active);
                    $stmtCredential->execute();

                    if ($stmtCredential->affected_rows != 1) {
                        $errorMsg = "Execute failed: (" . $stmtCredential->errno . ") " . $stmtCredential->error;
                        $success = false;
                    }
                    
                    // Insert into user_data and sensitive_info table
                    else {
                        
                        // Get the ID of the new registrant
                        $stmtGetID = $conn->prepare("SELECT * FROM customer_credentials WHERE customer_username=?");
                        $username = $_POST["username"];
                        $stmtGetID->bind_param("s", $username);
                        $stmtGetID->execute();
                        $result = $stmtGetID->get_result();
                        
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $id = $row["customer_id"];
                            
                            // Insert into user_data
                            $stmt_userDetail = $conn->prepare("INSERT INTO user_data (customer_id, first_name, last_name, full_name, street1, street2, postal, email, phone) VALUES (?,?,?,?,?,?,?,?,?)");
                            $stmt_userDetail->bind_param("issssssss",$id, $fname, $lname, $fullname, $street1, $street2, $postal, $email, $phone);
                            $stmt_userDetail->execute();
                            // Insert into sensitive_info
                            $stmt_sensitiveInfo = $conn->prepare("INSERT INTO sensitive_info (customer_id, ic_number, gender, date_of_birth) VALUES (?,?,?,?)");
                            $stmt_sensitiveInfo->bind_param("ssss",$id, $nric, $gender, $dob);
                            $stmt_sensitiveInfo->execute();
                        }
                    }
                        $stmtCredential->close();
                        $stmtGetID->close();
                        $stmt_userDetail->close();
                        $stmt_sensitiveInfo->close();
                        }
                        $conn->close();
                        
                    }
                    ?>

       </div>
    </div>
  </div>
</div>
</body>
</html>
