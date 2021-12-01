<?php ob_start(); ?>
<html lang="en">
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
                include_once ('php/connect.php');
                
                // Logging Variables
                $logSql = "INSERT INTO `log`(`type`,`category`, `description`, `user_performed`, `timestamp`) VALUES (?,?,?,?,CURRENT_TIMESTAMP)";
                $logType = "LOGIN";
                $logCategory0 = "INFO";
                $logCategory1 = "WARNING";
                $description = "";
                $noUser = "-EMPTY FIELD-";
                
                // IF REQUEST METHOD IS POST, NOT GET
                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    // Initialize variables
                    $errorMsg = "";
                    $success = true;

                    // FIRST NAME VALIDATION AND SANITIZATION (Nullable)
                    if (!empty($_POST["fname"])) {
                        $fname = sanitize_input($_POST["fname"]);
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
                        // Additional check on full name field.
                        $fullname = sanitize_input($_POST["fullname"]);
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
                        // Additional check on nric field.
                        $nric = sanitize_input($_POST["nric"]);
                        
                        if(!preg_match('/^[A-Za-z]{1}[0-9]{7}[A-Za-z]{1}$/', $nric)){
                            $errorMsg .= "Invalid NRIC / Password No.<br>";
                            $success = false;
                        }  
                    }
                    
                    // DOB VALIDATION AND SANITIZATION (Required)
                    if (empty($_POST["dob"])) {
                        $errorMsg .= "Date of Birth is required.<br>";
                        $success = false;
                    } else {
                        // Additional check on dob field.
                        $dob = sanitize_input($_POST["dob"]);
                        
                        if(!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $dob)){
                            $errorMsg .= "Invalid Date of Birth.<br>";
                            $success = false;
                        }  
                    }
                    
                    // GENDER VALIDATION AND SANITIZATION (Required)
                    if (empty($_POST["gender"])) {
                        $errorMsg .= "Gender is required.<br>";
                        $success = false;
                    } else {
                        // Additional check on gender field.
                        $gender = sanitize_input($_POST["gender"]);
                    }  

                    // STREET1 VALIDATION AND SANITIZATION, CONSIDER CHANGING TO POSTAL API (Required)
                    if (empty($_POST["street1"])) {
                        $errorMsg .= "Street1 is required.<br>";
                        $success = false;
                    } else {
                        // Additional check on street1 field.
                        $street1 = sanitize_input($_POST["street1"]);
                        //$street1 = htmlentities($_POST["street1"]);
                        if (!filter_var($street1, FILTER_SANITIZE_STRING)) {
                            $errorMsg .= "Invalid Street Name.<br>";
                            $success = false;
                        }
                    }

                    // STREET2 VALIDATION AND SANITIZATION, CONSIDER CHANGING TO POSTAL API (Nullable)
                    if (!empty($_POST["street2"])){
                        $street2 = sanitize_input($_POST["street2"]);
                        //$street2 = htmlentities($_POST["street2"]);
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
                        // Additional check on postal field.
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
                            checkEmailExist($connect);
                        }
                    }

                    // PHONE NO. VALIDATION AND SANITIZATION (Required)
                    if (empty($_POST["phone"])) {
                        $errorMsg .= "Phone Number is required.<br>";
                        $success = false;
                    } else {
                        // Additional check on phone field.
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
                        // Additional check on username field.
                        $username = sanitize_input($_POST["username"]);
                        
                        if(!preg_match('/^[A-Za-z][A-Za-z0-9]{5,31}$/', $username)){
                            $errorMsg .= "Username should contain only alphanumeric characters, length 5-30.<br>";
                            $success = false;
                        }
                        else{
                            checkUsernameExist($connect);
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
                        registerUser($connect);
                        
                        // Send confirmation email
                        include_once ('php/sendmail.php');
                        phpMailerRegistration($_POST["email"], $_POST["lname"]);
                        
                        echo "<h1>Registration Successful!</h1><br>";
                        echo "<p class='h4'>" . sanitize_input($_POST["lname"]) . ", you're now a member of Double04 Bank <i class='bi bi-emoji-sunglasses'></i></p><br>";
                        echo "<div class='alert alert-success' role='alert'> A confirmation email has been sent to ". sanitize_input($_POST["email"]). "</div>";
                        //date_default_timezone_set('Asia/Singapore');
                        //echo "<p class='h5'>" . date("Y/m/d") . " " . date("h:i:sa") . "</p><br>";
                        echo "<p>Redirecting back to Login page. Click on the button if the page does not redirect.</p>";
                        echo "<button onclick='goHome()' class='btn btn-success'>Login</button>";
                        echo "<br><br><br><br><br><br><br><br>";
                        header('Refresh: 10; URL=login.php');
                    }
                    // Else, show unsuccessful messages
                    else {
                        echo "<h1><i class='bi bi-exclamation-square'></i> Registration Unsuccessful</h1>";
                        echo "<p class='h4'>The following errors were detected:</p>";
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
            function checkEmailExist($connect) {
                global $email, $errorMsg, $success;
                
                $email = sanitize_input($_POST["email"]);
                $emailSql = "SELECT * FROM user_data WHERE email=?"; 
                $emailStmt = $connect->prepare($emailSql);
                $emailStmt->bindParam(1,$email, PDO::PARAM_STR);
                $emailStmt->execute();
                $emailResult = $emailStmt->fetchAll(PDO::FETCH_ASSOC);
                
                if(!empty($emailResult)) {
                    $errorMsg .= "This email has been registered.<br>";
                    $success = false;
                }
            }
            ?>
            
            
            
            <?php

            // Function to check if username has been used
            function checkUsernameExist($connect) {
                global $username, $errorMsg, $success;
                
                $userSql = "SELECT * FROM customer_credentials WHERE customer_username=?"; 
                $userStmt = $connect->prepare($userSql);
                $userStmt->bindParam(1,$username, PDO::PARAM_STR);
                $userStmt->execute();
                $userResult = $userStmt->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($userResult)) {
                    $errorMsg .= "Username has been taken, Please select another username.<br>";
                    $success = false;
                }
            }
            ?>
            <?php

            // Function to register user into DB
            function registerUser($connect) {
                global $username, $pwd_hashed, $fname, $lname, $fullname, $street1, $street2, $postal, $email, $phone, $nric, $gender, $dob, $errorMsg, $success;
                
                $otp = "12345";
                $rndno = rand(1, 9999999);
                $token = md5($rndno);
                $active = 1;
                
                $userCredRegSql = "INSERT INTO customer_credentials (customer_username, password_hash, otp, password_token, active) VALUES (?,?,?,?,?)"; 
                $userCredRegStmt = $connect->prepare($userCredRegSql);
                $userCredRegStmt->bindParam(1,$username, PDO::PARAM_STR);
                $userCredRegStmt->bindParam(2,$pwd_hashed, PDO::PARAM_STR);
                $userCredRegStmt->bindParam(3,$otp, PDO::PARAM_STR);
                $userCredRegStmt->bindParam(4,$token, PDO::PARAM_STR);
                $userCredRegStmt->bindParam(5,$active, PDO::PARAM_STR);
                $userCredRegStmt->execute();
                
                if ($userCredRegStmt->rowCount() == 1) {
                    $getIdSql = "SELECT `customer_id` FROM customer_credentials WHERE customer_username=?"; 
                    $getIdStmt = $connect->prepare($getIdSql);
                    $getIdStmt->bindParam(1,$username, PDO::PARAM_STR);
                    $getIdStmt->execute();
                    $getIdResult = $getIdStmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    if(!empty($getIdResult)){
                        $id = $getIdResult[0]["customer_id"];
                        
                        $userDataRegSql = "INSERT INTO user_data "
                                . "(customer_id, first_name, last_name, full_name, street1, street2, postal, email, phone) "
                                . "VALUES (?,?,?,?,?,?,?,?,?)"; 
                        $userDataRegStmt = $connect->prepare($userDataRegSql);
                        $userDataRegStmt->bindParam(1, $id, PDO::PARAM_STR);
                        $userDataRegStmt->bindParam(2, $fname, PDO::PARAM_STR);
                        $userDataRegStmt->bindParam(3, $lname, PDO::PARAM_STR);
                        $userDataRegStmt->bindParam(4, $fullname, PDO::PARAM_STR);
                        $userDataRegStmt->bindParam(5, $street1, PDO::PARAM_STR);
                        $userDataRegStmt->bindParam(6, $street2, PDO::PARAM_STR);
                        $userDataRegStmt->bindParam(7, $postal, PDO::PARAM_STR);
                        $userDataRegStmt->bindParam(8, $email, PDO::PARAM_STR);
                        $userDataRegStmt->bindParam(9, $phone, PDO::PARAM_STR);
                        $userDataRegStmt->execute();
                        
                        if ($userDataRegStmt->rowCount() == 1) {
                            $userSensRegSql = "INSERT INTO sensitive_info "
                                    . "(customer_id, ic_number, gender, date_of_birth) "
                                    . "VALUES (?,?,?,?)"; 
                            $userSensRegStmt = $connect->prepare($userSensRegSql);
                            $userSensRegStmt->bindParam(1, $id, PDO::PARAM_STR);
                            $userSensRegStmt->bindParam(2, $nric, PDO::PARAM_STR);
                            $userSensRegStmt->bindParam(3, $gender, PDO::PARAM_STR);
                            $userSensRegStmt->bindParam(4, $dob, PDO::PARAM_STR);
                            $userSensRegStmt->execute();
                        }
                        else{
                            $errorMsg = "Database Error";
                        }
                    }
                    else {
                        $errorMsg = "Database Error";
                    }
                }
            }
                    ?>

       </div>
    </div>
  </div>
</div>
</body>
</html>
