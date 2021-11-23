<?php //include "php/session.php";  ?>
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
        <div class="page-content">
            <div class="main-content">

                <?php
                // IF REQUEST METHOD IS POST, NOT GET
                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    // Initialize variables
                    $errorMsg = "";
                    $success = true;

                    // FIRST NAME VALIDATION AND SANITIZATION (Nullable)
                    $fname = sanitize_input($_POST["fname"]);
                    if (!filter_var($fname, FILTER_SANITIZE_STRING)) {
                        $errorMsg .= "Invalid Name format.";
                        $success = false;
                    }

                    // LAST NAME VALIDATION AND SANITIZATION (Required)
                    if (empty($_POST["lname"])) {
                        $errorMsg .= "Last Name is required.<br>";
                        $success = false;
                    } else {
                        // Additional check on last name field.
                        $lname = sanitize_input($_POST["lname"]);
                        if (!filter_var($lname, FILTER_SANITIZE_STRING)) {
                            $errorMsg .= "Invalid Name format.";
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
                        if (!filter_var($fullname, FILTER_SANITIZE_STRING)) {
                            $errorMsg .= "Invalid Name format.";
                            $success = false;
                        }
                    }

                    // STREET1 VALIDATION AND SANITIZATION, CONSIDER CHANGING TO POSTAL API (Required)
                    if (empty($_POST["street1"])) {
                        $errorMsg .= "Street1 is required.<br>";
                        $success = false;
                    } else {
                        // Additional check on last name field.
                        $street1 = sanitize_input($_POST["street1"]);
                        if (!filter_var($street1, FILTER_SANITIZE_STRING)) {
                            $errorMsg .= "Invalid Street Name.";
                            $success = false;
                        }
                    }

                    // STREET2 VALIDATION AND SANITIZATION, CONSIDER CHANGING TO POSTAL API (Nullable)
                    // Additional check on last name field.
                    $street2 = sanitize_input($_POST["street2"]);
                    if (!filter_var($street2, FILTER_SANITIZE_STRING)) {
                        $errorMsg .= "Invalid Street Name.";
                        $success = false;
                    }

                    // POSTAL CODE VALIDATION AND SANITIZATION (Required)
                    if (empty($_POST["postal"])) {
                        $errorMsg .= "Postal Code is required.<br>";
                        $success = false;
                    } else {
                        // Additional check on last name field.
                        $postal = sanitize_input($_POST["postal"]);
                        if (!filter_var($postal, FILTER_SANITIZE_STRING)) {
                            $errorMsg .= "Invalid Postal Code.";
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
                            $errorMsg .= "Invalid Phone Number.";
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
                            $errorMsg .= "Username should contain only alphanumeric characters, length 5-30.";
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
                        if (strlen($_POST['pwd']) < '8') {
                            $errorMsg .= "Password Must Contain At Least 8 Characters!<br>";
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
                        updateCredential();
                        
                        echo "<h3>Registration Successful!</h3><br>";
                        echo "<h3>" . $_POST["lname"] . ", you're now a member of Double04 Bank <i class='bi bi-emoji-sunglasses'></i></h3><br>";
                        // TO-DO Implement PHP mail to send success registration email
                        echo "<h3> A confirmation email has been sent to ". $POST_["email"]. "</h3>";
                        date_default_timezone_set('Asia/Singapore');
                        echo "<h5>" . date("Y/m/d") . " " . date("h:i:sa") . "</h5><br>";
                        echo "<p><button onclick='goHome()' class='home_btn'>Home</button></p>";
                        echo "<br><br><br><br><br><br><br><br>";
                    }
                    // Else, show unsuccessful messages
                    else {
                        echo "<h3>Registration Unsuccessful</h3>";
                        echo "<h5>The following errors were detected:</h5>";
                        echo "<p style='color:red'>" . $errorMsg . "</p>";
                        echo "<p><button onclick='goBack()' class='return_btn'>Return to update details</button></p>";
                        echo "<br><br><br><br><br><br><br><br>";
                    }
                }

                // If user try to navigate to process_update_profile using direct URL (This process is a POST method) 2nd Layer - 1st layer Session set.
                else {
                    echo "<h3>Error</h3>";
                    echo "<br><br><br><br><br><br><br><br>";
                }

                //Helper function that checks input for malicious or unwanted content.
                function sanitize_input($data) {
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = htmlspecialchars($data);
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
                global $fname, $lname, $fullname, $street1, $street2, $postal, $email, $phone, $errorMsg, $success;
                // Create database connection.
                // TODO - CHANGE TO PDO
                $config = parse_ini_file('../../private/db-config.ini');
                $conn = new mysqli($config['servername'], $config['username'],
                        $config['password'], $config['dbname']);
                // Check connection
                if ($conn->connect_error) {
                    $errorMsg = "Connection failed: " . $conn->connect_error;
                    $success = false;
                } else {
                    // Prepare the statement:
                    $stmt_userDetail = $conn->prepare("INSERT INTO user_data (first_name, last_name, full_name, street1, street2, postal, email, phone) VALUES (?,?,?,?,?,?,?,?)");
                    $stmt_userDetail->bind_param("ssssssss", $fname, $lname, $fullname, $street1, $street2, $postal, $email, $phone);
                    $stmt_userDetail->execute();

                    if ($stmt_userDetail->affected_rows != 1) {
                        $errorMsg = "Execute failed: (" . $stmt_userDetail->errno . ") " . $stmt_userDetail->error;
                        $success = false;
                    }
                    $stmt_userDetail->close();
                }
                $conn->close();
            }
            ?>

            <?php

            // Function to register user into DB
            function updateCredential() {
                global $username, $pwd_hashed, $errorMsg, $success;
                // Create database connection.
                // TODO - CHANGE TO PDO
                $config = parse_ini_file('../../private/db-config.ini');
                $conn = new mysqli($config['servername'], $config['username'],
                        $config['password'], $config['dbname']);
                // Check connection
                if ($conn->connect_error) {
                    $errorMsg = "Connection failed: " . $conn->connect_error;
                    $success = false;
                } else {
                    // Prepare the statement:
                    $stmt_userCredential = $conn->prepare("INSERT INTO customer_credentials (customer_username, password_hash, otp, password_token, active) VALUES (?,?,?,?,?)");
                    
                    // TO DO - customer_username, OTP, password_token, active
                    $dump = 'asdf';
                    $active = 1;
                    $stmt_userCredential->bind_param("ssssi", $username, $pwd_hashed, $dump, $dump, $active);
                    $stmt_userCredential->execute();

                    if ($stmt_userCredential->affected_rows != 1) {
                        $errorMsg = "Execute failed: (" . $stmt_userCredential->errno . ") " . $stmt_userCredential->error;
                        $success = false;
                    }
                    $stmt_userCredential->close();
                }
                $conn->close();
            }
            ?>

        </div>
    </div>
</div>
</body>
</html>