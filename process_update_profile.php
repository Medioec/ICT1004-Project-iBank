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

                    // FIRST NAME VALIDATION AND SANITIZATION
                    // Additional check on last name field.
                    $fname = sanitize_input($_POST["fname"]);
                    if (!filter_var($fname, FILTER_SANITIZE_STRING)) {
                        $errorMsg .= "Invalid Name format.";
                        $success = false;
                    }


                    // LAST NAME VALIDATION AND SANITIZATION
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


                    // FULL NAME VALIDATION AND SANITIZATION
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


                    // STREET1 VALIDATION AND SANITIZATION, CONSIDER CHANGING TO POSTAL API
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

                    // STREET2 VALIDATION AND SANITIZATION, CONSIDER CHANGING TO POSTAL API
                    // Additional check on last name field.
                    $street2 = sanitize_input($_POST["street2"]);
                    if (!filter_var($street2, FILTER_SANITIZE_STRING)) {
                        $errorMsg .= "Invalid Street Name.";
                        $success = false;
                    }


                    // POSTAL CODE VALIDATION AND SANITIZATION, 
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


                    // EMAIL VALIDATION AND SANITIZATION
                    if (empty($_POST["email"])) {
                        $errorMsg .= "Email is required.<br>";
                        $success = false;
                    } else {
                        $email = sanitize_input($_POST["email"]);
                        // Additional check to make sure e-mail address is well-formed.
                        // VALIDATING USING REGEX
                        $emailregex = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
                        if (!preg_match($emailregex, $email)) {
                            $errorMsg .= "Invalid email format.<br>";
                            $success = false;
                        }
                        // VALIDATING USING PHP BUILT-IN FUNCTION
                        #if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        #$errorMsg .= "Invalid email format.<br>";
                        #$success = false;
                        #}
                    }


                    // PHONE NO. VALIDATION AND SANITIZATION, 
                    if (empty($_POST["phone"])) {
                        $errorMsg .= "Phone Number is required.<br>";
                        $success = false;
                    } else {
                        // Additional check on last name field.
                        $phone = sanitize_input($_POST["phone"]);
                        if (!filter_var($phone, FILTER_SANITIZE_STRING)) {
                            $errorMsg .= "Invalid Postal Code.";
                            $success = false;
                        }
                    }


                    // PASSWORD VALIDATION FOR CURRENT PASWWORD
                    if (empty($_POST['pwd'])) {
                        $errorMsg .= "Please enter your current password.<br>";
                        $success = false;
                    }
                    // VALIDATING USING REGEX
                    else {
                        if (strlen($_POST['pwd']) < '8') {
                            $errorMsg = "Your Password Must Contain At Least 8 Characters!<br>";
                            $success = false;
                        } elseif (!preg_match("#[0-9]+#", $_POST["pwd"])) {
                            $errorMsg = "Your Password Must Contain At Least 1 Number!<br>";
                            $success = false;
                        } elseif (!preg_match("#[A-Z]+#", $_POST["pwd"])) {
                            $errorMsg = "Your Password Must Contain At Least 1 Capital Letter!<br>";
                            $success = false;
                        } elseif (!preg_match("#[a-z]+#", $_POST["pwd"])) {
                            $errorMsg = "Your Password Must Contain At Least 1 Lowercase Letter!<br>";
                            $success = false;
                        }

                        // TODO - Check if current password matches current session password
                        //    elseif ($_POST['pwd'] !== $_POST['']) {
                        //        $errorMsg = "Your Password Does Not Match!<br>";
                        //        $success = false;
                        //    } 
                        else {
                            // HASH THE PASSWORD
                            $pwd_hashed = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
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
                            if (strlen($_POST['new_pwd']) < '8') {
                                $errorMsg = "Your Password Must Contain At Least 8 Characters!<br>";
                                $success = false;
                            } elseif (!preg_match("#[0-9]+#", $_POST["new_pwd"])) {
                                $errorMsg = "Your Password Must Contain At Least 1 Number!<br>";
                                $success = false;
                            } elseif (!preg_match("#[A-Z]+#", $_POST["new_pwd"])) {
                                $errorMsg = "Your Password Must Contain At Least 1 Capital Letter!<br>";
                                $success = false;
                            } elseif (!preg_match("#[a-z]+#", $_POST["new_pwd"])) {
                                $errorMsg = "Your Password Must Contain At Least 1 Lowercase Letter!<br>";
                                $success = false;
                            } elseif ($_POST['new_pwd'] == $_POST['pwd']) {
                                $errorMsg = "New password cannot be same as Old password!<br>";
                                $success = false;
                            } elseif ($_POST['new_pwd'] !== $_POST['cfm_pwd']) {
                                $errorMsg = "Your New Password Does Not Match!<br>";
                                $success = false;
                            } else {
                                // HASH THE PASSWORD
                                $new_pwd_hashed = password_hash($_POST["new_pwd"], PASSWORD_DEFAULT);
                            }
                        }
                    }


                    // If Success = True 
                    if ($success) {
                        updateUserDetails();
                        updatePassword();
                        echo "<h3>Your profile details have been updated</h3><br>";
                        date_default_timezone_set('Asia/Singapore');
                        echo "<h5>" . date("Y/m/d") . " " . date("h:i:sa") . "</h5><br>";
                        echo "<p><button onclick='goHome()' class='home_btn'>Home</button></p>";
                        echo "<br><br><br><br><br><br><br>";
                    } else {
                        echo "<h3>Unsuccessful update</h3>";
                        echo "<h5>The following errors were detected:</h5>";
                        echo "<p style='color:red'>" . $errorMsg . "</p>";
                        echo "<p><button onclick='goBack()' class='return_btn'>Return to update details</button></p>";
                    }
                }

                // If user try to navigate to process_update_profile using direct URL
                else {
                    echo "<h3>Error</h3>";
                    echo "<br><br><br><br><br><br><br>";
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

            // Function to update user details
            function updateUserDetails() {
                global $fname, $lname, $fullname, $street1, $street2, $postal, $email, $phone, $email, $errorMsg, $success;
                // Create database connection.
                // TO DO - CHANGE TO PDO
                $config = parse_ini_file('../../private/db-config.ini');
                $conn = new mysqli($config['servername'], $config['username'],
                        $config['password'], $config['dbname']);
                // Check connection
                if ($conn->connect_error) {
                    $errorMsg = "Connection failed: " . $conn->connect_error;
                    $success = false;
                } else {
                    // Prepare the statement:
                    $stmt = $conn->prepare("UPDATE user_data SET first_name=?, last_name=?, full_name=?, street1=?, street2=?, postal=?, email=?, phone=? WHERE customer_id=?");
                    // HARD CODED - TO DO CHANGE TO SESSION
                    $id = 1;
                    $stmt->bind_param("ssssssssi", $fname, $lname, $fullname, $street1, $street2, $postal, $email, $phone, $id);
                    $stmt->execute();
                    if (!$stmt->affected_rows != 1) {
                        $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                        $success = false;
                    }
                    $stmt->close();
                }
                $conn->close();
            }
            ?>

            <?php

            // Function to update user password
            function updatePassword() {
                global $new_pwd_hashed, $errorMsg, $success;
                // Create database connection.
                // TO DO - CHANGE TO PDO
                $config = parse_ini_file('../../private/db-config.ini');
                $conn = new mysqli($config['servername'], $config['username'],
                        $config['password'], $config['dbname']);
                // Check connection
                if ($conn->connect_error) {
                    $errorMsg = "Connection failed: " . $conn->connect_error;
                    $success = false;
                } else {
                    // Prepare the statement:
                    $stmt = $conn->prepare("UPDATE customer_credentials SET password_hash=? WHERE customer_id=?");

                    // HARD CODED - TO DO CHANGE TO SESSION
                    $id = 1;
                    $stmt->bind_param("si", $new_pwd_hashed, $id);
                    $stmt->execute();

                    if (!$stmt->affected_rows != 1) {
                        $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                        $success = false;
                    }
                    $stmt->close();
                }
                $conn->close();
            }
            ?>

        </div>
    </div>
</div>
</body>
</html>