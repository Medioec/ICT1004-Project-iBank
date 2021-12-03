<?php include "session.php"; ?>
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
                $logType = "PROFILE-UPDATE";
                $logCategory0 = "INFO";
                $logCategory1 = "WARNING";
                $description = "FAILED USER PROFILE UPDATE - CUSTOMER ( ";
                $username = $_SESSION['username'];
                $id = $_SESSION["customerId"];
                
                $patternAlphanumeric = "/^[A-Za-z][A-Za-z0-9]{5,31}$/";
                $patternAlphaSpace = "/^[\w\-\s]+$/";
                $patternNumeric = "/^[0-9]*$/";
                $patternPhone = "/^[0-9 +-]*$/";
                $patternAddress = "/^[\w\-\s#@]+$/";
                
                $changePw = false;
                
                // IF REQUEST METHOD IS POST, NOT GET
                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    // Initialize variables
                    $errorMsg = "";
                    $success = true;
                    
                    // Get email address
                    $getEmailSql = "SELECT * FROM user_data WHERE customer_id=?";
                    $getEmailStmt = $connect->prepare($getEmailSql);
                    $getEmailStmt->bindParam(1, $id, PDO::PARAM_INT);
                    $getEmailStmt->execute();
                    $getEmailResult = $getEmailStmt->fetchAll(PDO::FETCH_ASSOC);
                    $current_email = htmlentities($getEmailResult[0]["email"]);
                    
                    // FIRST NAME VALIDATION AND SANITIZATION (Nullable)
                    if (!empty($_POST["fname"])) {
                        $fname = sanitize_input($_POST["fname"]);
                        if (!preg_match($patternAlphaSpace,$fname)) {
                            $errorMsg .= "Invalid First Name format.<br>";
                            $description .= "FNAME-ERR ";
                            $success = false;
                        }
                    }

                    // LAST NAME VALIDATION AND SANITIZATION (Required)
                    if (empty($_POST["lname"])) {
                        $errorMsg .= "Last Name is required.<br>";
                        $description .= "LNAME-ERR ";
                        $success = false;
                    } else {
                        // Additional check on last name field.
                        $lname = sanitize_input($_POST["lname"]);
                        if (!preg_match($patternAlphaSpace,$lname)) {
                            $errorMsg .= "Invalid Last Name format.<br>";
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
                        if (!preg_match($patternAlphaSpace,$fullname)) {
                            $errorMsg .= "Invalid Full Name format.<br>";
                            $description .= "FULLNAME-ERR ";
                            $success = false;
                        }
                    }

                    // STREET1 VALIDATION AND SANITIZATION, CONSIDER CHANGING TO POSTAL API (Required)
                    if (empty($_POST["street1"])) {
                        $errorMsg .= "Street1 is required.<br>";
                        $success = false;
                    } else {
                        // Additional check on street1 field.
                        $street1 = sanitize_input($_POST["street1"]);
                        if (!preg_match($patternAddress,$street1)) {
                            $errorMsg .= "Invalid Street 1.<br>";
                            $description .= "STREET1-ERR ";
                            $success = false;
                        }
                    }

                    // STREET2 VALIDATION AND SANITIZATION, CONSIDER CHANGING TO POSTAL API (Nullable)
                    if (!empty($_POST["street2"])){
                        $street2 = sanitize_input($_POST["street2"]);
                        if (!preg_match($patternAddress,$street2)) {
                        $errorMsg .= "Invalid Street 2.<br>";
                        $description .= "STREET2-ERR ";
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
                        if (!preg_match($patternNumeric,$postal)) {
                            $errorMsg .= "Invalid Postal Code.<br>";
                            $description .= "POSTAL-ERR ";
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
                            $description .= "EMAIL-ERR ";
                            $success = false;
                        }
                        else{
                            // Check if user edited email, if so, check if email is unique in database
                            if($_POST["email"] != $current_email){
                                checkEmailExist($connect);
                            }
                        }
                    }
					
                    
                    // PHONE NO. VALIDATION AND SANITIZATION (Required)
                    if (empty($_POST["phone"])) {
                        $errorMsg .= "Phone Number is required.<br>";
                        $success = false;
                    } else {
                        // Additional check on phone field.
                        $phone = sanitize_input($_POST["phone"]);
                        if (!preg_match($patternPhone,$phone)) {
                            $errorMsg .= "Invalid Phone Number.<br>";
                            $description .= "PHONE-ERR ";
                            $success = false;
                        }
                    }

                    // PASSWORD VALIDATION FOR CURRENT PASWWORD (Required)
                    if (empty($_POST['pwd'])) {
                        $errorMsg .= "Please enter your current password.<br>";
                        $success = false;
                    }
                    // VALIDATING USING REGEX
                    else {
                        if (strlen($_POST['pwd']) < '12') {
                            $errorMsg = "Incorrect Password!<br>";
                            $success = false;
                        } elseif (!preg_match("#[0-9]+#", $_POST["pwd"])) {
                            $errorMsg = "Incorrect Password!<br>";
                            $success = false;
                        } elseif (!preg_match("#[A-Z]+#", $_POST["pwd"])) {
                            $errorMsg = "Incorrect Password!<br>";
                            $success = false;
                        } elseif (!preg_match("#[a-z]+#", $_POST["pwd"])) {
                            $errorMsg = "Incorrect Password!<br>";
                            $success = false;
                        }
                        // IF Passed REGEX validation, Cross check with DB for current password
                        else {
                            // HASH THE PASSWORD and check if it matches password in DB
                            $pwd_hashed = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
                            checkCurrentPwd($connect);
                        }
                    }
                    
                    
                    // If user decides to change password, Check if new_pwd is !empty
                    if (!empty($_POST['new_pwd'])) {
                        // PASSWORD VALIDATION FOR NEW PASWWORD
                        if (empty($_POST['new_pwd']) || empty($_POST["cfm_pwd"])) {
                            $errorMsg .= "Please enter your new password and confirm new password.<br>";
                            $success = false;
                        }
                        // VALIDATING USING REGEX
                        else {
                            if (strlen($_POST['new_pwd']) < '12') {
                                $errorMsg .= "New Password Must Contain At Least 12 Characters!<br>";
                                $success = false;
                            } elseif (!preg_match("#[0-9]+#", $_POST["new_pwd"])) {
                                $errorMsg .= "New Password Must Contain At Least 1 Number!<br>";
                                $success = false;
                            } elseif (!preg_match("#[A-Z]+#", $_POST["new_pwd"])) {
                                $errorMsg .= "New Password Must Contain At Least 1 Capital Letter!<br>";
                                $success = false;
                            } elseif (!preg_match("#[a-z]+#", $_POST["new_pwd"])) {
                                $errorMsg .= "New Password Must Contain At Least 1 Lowercase Letter!<br>";
                                $success = false;
                            } elseif ($_POST['new_pwd'] !== $_POST['cfm_pwd']) {
                                $errorMsg .= "New Password Does Not Match!<br>";
                                $success = false;
                            }elseif ($_POST['new_pwd'] == $_POST['pwd']) {
                                $errorMsg .= "New password cannot be same as Old password!<br>";
                                $success = false;
                            } 
                            else {
                                // HASH THE NEW PASSWORD $$new_pwd_hashed to be updated into DB
                                $new_pwd_hashed = password_hash($_POST["new_pwd"], PASSWORD_DEFAULT);
                                $changePw = true;
                            }
                            
                            if(!$changePw){
                                $description .= "NEW-PW-INVALID ";
                            }
                        }
                    }


                    // If Success, Update information into DB
                    if ($success) {
                        updateUserDetails($connect);
                        if ($changePw) {
                            updatePassword($connect);
                        }
                        echo "<h3>Your profile details have been updated</h3><br>";
                        date_default_timezone_set('Asia/Singapore');
                        echo "<p class='h5'>" . date("Y/m/d") . " " . date("h:i:sa") . "</p><br>";
                        echo "<p><button onclick='goHome()' class='btn btn-primary'>Home</button></p>";
                        echo "<br><br><br><br><br><br><br><br>";
                    }
                    // Else, show unsuccessful messages
                    else {
                        echo "<h3>Unsuccessful Update</h3>";
                        echo "<p class='h5'><i class='bi bi-exclamation-square'></i> The following errors were detected:</p>";
                        echo "<p style='color:red'>" . $errorMsg . "</p>";
                        echo "<p><button onclick='goBack()' class='btn btn-primary'>Return to Update Details</button></p>";
                        echo "<br><br><br><br><br><br><br><br>";
                        
                        $description .= ")";
                        $failSql = $logSql;
                        $failLog = $connect->prepare($failSql);
                        $failLog->bindParam(1,$logType, PDO::PARAM_STR);
                        $failLog->bindParam(2,$logCategory1, PDO::PARAM_STR);
                        $failLog->bindParam(3,$description, PDO::PARAM_STR);
                        $failLog->bindParam(4,$username, PDO::PARAM_STR);
                        $failLog->execute();
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
            // Function to cross check current password = password in DB
            function checkCurrentPwd($connect) {
                global $curr_pwd_hashed, $errorMsg, $success, $description;
                
                $id = $_SESSION["customerId"];
                // Prepare the statement:
                $getPwdSql = "SELECT `password_hash` FROM customer_credentials WHERE customer_id=?"; 
                $getPwdStmt = $connect->prepare($getPwdSql);
                $getPwdStmt->bindParam(1,$id, PDO::PARAM_INT);
                try{
                    $getPwdStmt->execute();
                    $getPwdResult = $getPwdStmt->fetchAll(PDO::FETCH_ASSOC);
                } 
                catch (PDOException $e) {
                    echo "Database error, contact support";
                    //echo "Database error: " . $e->getMessage();
                    $success = false;
                }
                
                if($getPwdStmt->rowCount() == 1) {
                    $curr_pwd_hashed = $getPwdResult[0]["password_hash"];
                    
                    // Check if current password user has entered == DB password
                    if (!password_verify($_POST["pwd"], $curr_pwd_hashed)) {
                        $errorMsg .= "Incorrect Password... Please verify with your current password<br>";
                        $description .= "PW-INVALID ";
                        $success = false;
                    }
                }
                else {
                    $errorMsg = "Error, no data found";
                    $description .= "PW-NOT-FOUND ";
                    $success = false;
                }
            }
			
            function checkEmailExist($connect) {
                global $email, $errorMsg, $success;

                $email = sanitize_input($_POST["email"]);
                $emailSql = "SELECT * FROM user_data WHERE email=?";
                $emailStmt = $connect->prepare($emailSql);
                $emailStmt->bindParam(1, $email, PDO::PARAM_STR);
                try{
                    $emailStmt->execute();
                    $emailResult = $emailStmt->fetchAll(PDO::FETCH_ASSOC);
                } 
                catch (PDOException $e) {
                    echo "Database error, contact support";
                    //echo "Database error: " . $e->getMessage();
                    $success = false;
                }

                if (!empty($emailResult)) {
                    $errorMsg .= "Unable to change email. This email has been registered.<br>";
                    $success = false;
                }
            }
			
            // Function to update user details into DB
            function updateUserDetails($connect) {
                global $fname, $lname, $fullname, $street1, $street2, $postal, $email, $phone, $errorMsg, $success;
                global $logSql, $logType, $logCategory0, $logCategory1, $username;
                $description = "";
                $logCategory = $logCategory1;
                $id = $_SESSION["customerId"];
                
                // Prepare the statement:
                $updateInfoSql = "UPDATE user_data SET "
                        . "first_name=?, last_name=?, full_name=?, "
                        . "street1=?, street2=?, postal=?, "
                        . "email=?, phone=? WHERE customer_id=?"; 
                $updateInfoStmt = $connect->prepare($updateInfoSql);
                $updateInfoStmt->bindParam(1,$fname, PDO::PARAM_STR);
                $updateInfoStmt->bindParam(2,$lname, PDO::PARAM_STR);
                $updateInfoStmt->bindParam(3,$fullname, PDO::PARAM_STR);
                $updateInfoStmt->bindParam(4,$street1, PDO::PARAM_STR);
                $updateInfoStmt->bindParam(5,$street2, PDO::PARAM_STR);
                $updateInfoStmt->bindParam(6,$postal, PDO::PARAM_STR);
                $updateInfoStmt->bindParam(7,$email, PDO::PARAM_STR);
                $updateInfoStmt->bindParam(8,$phone, PDO::PARAM_STR);
                $updateInfoStmt->bindParam(9,$id, PDO::PARAM_STR);
                
                try{
                    $updateInfoStmt->execute();
                } 
                catch (PDOException $e) {
                    echo "Database error, contact support";
                    //echo "Database error: " . $e->getMessage();
                    $success = false;
                }
                
                if ($updateInfoStmt->rowCount() != 1) {
                    $errorMsg = "Error, please contact bank for help.";
                    $success = false;
                    
                    $description = "FAILED USER PROFILE UPDATE - CUSTOMER (USER-DATA-TABLE-ERR)";
                    $logCategory = $logCategory1;
                }
                else {
                    $description = "USER PROFILE UPDATE - CUSTOMER (SUCCESS)";
                    $logCategory = $logCategory0;
                }
                $sql = $logSql;
                $log = $connect->prepare($sql);
                $log->bindParam(1,$logType, PDO::PARAM_STR);
                $log->bindParam(2,$logCategory, PDO::PARAM_STR);
                $log->bindParam(3,$description, PDO::PARAM_STR);
                $log->bindParam(4,$username, PDO::PARAM_STR);
                $log->execute();
                
                if ($fname) {
                    $_SESSION["displayName"] = $fname;
                } else {
                    $_SESSION["displayName"] = $lname;
                }
            }
            ?>

            <?php
            // Function to update user password into DB
            function updatePassword($connect) {
                global $new_pwd_hashed, $errorMsg, $success;
                global $logSql, $logType, $logCategory0, $logCategory1, $username;
                $description = "";
                $logCategory = $logCategory1;
                $id = $_SESSION["customerId"];
                
                // Prepare the statement:
                $changePwdSql = "UPDATE customer_credentials SET password_hash=? WHERE customer_id=?"; 
                $changePwdStmt = $connect->prepare($changePwdSql);
                $changePwdStmt->bindParam(1,$new_pwd_hashed, PDO::PARAM_STR);
                $changePwdStmt->bindParam(2,$id, PDO::PARAM_INT);
                try{
                    $changePwdStmt->execute();
                } 
                catch (PDOException $e) {
                    echo "Database error, contact support";
                    //echo "Database error: " . $e->getMessage();
                    $success = false;
                }
                
                if ($changePwdStmt->rowCount() != 1) {
                    $errorMsg = "Error, please contact bank for help.";
                    $success = false;
                    
                    $description = "FAILED USER PASSWORD UPDATE - CUSTOMER (CUSTOMER-CRED-TABLE-ERR)";
                    $logCategory = $logCategory1;
                }
                else {
                    $description = "USER PASSWORD UPDATE - CUSTOMER (SUCCESS)";
                    $logCategory = $logCategory0;
                }
                $sql = $logSql;
                $log = $connect->prepare($sql);
                $log->bindParam(1,$logType, PDO::PARAM_STR);
                $log->bindParam(2,$logCategory, PDO::PARAM_STR);
                $log->bindParam(3,$description, PDO::PARAM_STR);
                $log->bindParam(4,$username, PDO::PARAM_STR);
                $log->execute();
            }
            ?>

        </div>
    </div>
</div>
</div>
</body>
</html>