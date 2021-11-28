<?php //include "session.php";?>
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

                    // PASSWORD VALIDATION FOR CURRENT PASWWORD (Required)
                    if (empty($_POST['pwd'])) {
                        $errorMsg .= "Please enter your current password.<br>";
                        $success = false;
                    }
                    // VALIDATING USING REGEX
                    else {
                        if (strlen($_POST['pwd']) < '8') {
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
                            checkCurrentPwd();
                            checkAccountBalance();
                        }
                    }
                    
                    
                    // If Success, Deactive account and destroy session
                    if ($success) {
                        deactivateAccount();
                        session_unset();
                        session_destroy();
                        echo "<h3>Your account has be deactivated</h3><br>";
                        date_default_timezone_set('Asia/Singapore');
                        echo "<h5>" . date("Y/m/d") . " " . date("h:i:sa") . "</h5><br>";
                        echo "<p><button onclick='goHome()' class='home_btn'>Home</button></p>";
                        echo "<br><br><br><br><br><br><br><br>";
                    }
                    // Else, show unsuccessful messages
                    else {
                        echo "<h3>Unsuccessful</h3>";
                        echo "<h5>The following errors were detected:</h5>";
                        echo "<p style='color:red'>" . $errorMsg . "</p>";
                        echo "<p><button onclick='goBack()' class='return_btn'>Back</button></p>";
                        echo "<br><br><br><br><br><br><br><br>";
                    }
                }

                // If user try to navigate using direct URL (This process is a POST method)
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
            function checkCurrentPwd() {
                global $pwd_hashed, $errorMsg, $success;

                // Create database connection.
                $config = parse_ini_file('../../private/db-config.ini');
                $conn = new mysqli($config['servername'], $config['username'],
                        $config['password'], $config['dbname']);

                // Check connection
                if ($conn->connect_error) {
                    $errorMsg = "Connection failed: " . $conn->connect_error;
                    $success = false;
                } 
                else {
                    $stmt = $conn->prepare("SELECT * FROM customer_credentials WHERE customer_id=?");
                    // HARD CODED - TODO CHANGE TO SESSION
                    //$id = $_SESSION["customerId"];
                    $id = 6;
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $pwd_hashed = $row["password_hash"];

                        // Check if current password user has entered == DB password
                        if (!password_verify($_POST["pwd"], $pwd_hashed)) {
                            $errorMsg = "Incorrect Password... Please enter current password to proceed";
                            $success = false;
                        }

                    } 
                    else {
                        $errorMsg = "Error, no data found";
                        $success = false;
                    }
                    $stmt->close();
                }
                $conn->close();
            }
            ?>
                    
            <?php        
            
            // Function to check if balance in all accounts is 0 before deactivation
            function checkAccountBalance() {
                global $balance, $errorMsg, $success;

                // Create database connection.
                $config = parse_ini_file('../../private/db-config.ini');
                $conn = new mysqli($config['servername'], $config['username'],
                        $config['password'], $config['dbname']);

                // Check connection
                if ($conn->connect_error) {
                    $errorMsg = "Connection failed: " . $conn->connect_error;
                    $success = false;
                }

                else {
                    //$stmt = $conn->prepare("SELECT * FROM bank_account B, bank_accounts_ref R WHERE customer_id = ? AND B.account_id = R.account_id");
                    $stmt = $conn->prepare("SELECT sum(balance) AS acc_sum FROM bank_account B, bank_accounts_ref R WHERE customer_id = ? AND B.account_id = R.account_id");
                    
                    // HARD CODED - TODO CHANGE TO SESSION
                    //$id = $_SESSION["customerId"];
                    $id = 6;
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    //$balance = $row["balance"];
                    $balance = $row["acc_sum"];
                    
                    if ($balance > 0.00) {
                        $errorMsg = "You have outstanding balance in your accounts, please head down to the bank to process deactivation.";
                        $success = false;
                        
                    }
                    $stmt->close();
                }
                $conn->close();
            }
            ?>

            <?php
            // Function to deactivate account
            function deactivateAccount() {
                global $active, $errorMsg, $success;
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
                    $stmt = $conn->prepare("UPDATE customer_credentials SET active=? WHERE customer_id=?");

                     // HARD CODED - TODO CHANGE TO SESSION
                    //$id = $_SESSION["customerId"];
                    $id = 6;
                    $active = 0;
                    $stmt->bind_param("ii", $active, $id);
                    $stmt->execute();

                    if ($stmt->affected_rows != 1) {
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
</div>
</body>
</html>