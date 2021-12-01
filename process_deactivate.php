<?php 
ob_start();
include "session.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
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
                $logType = "ACCOUNT";
                $logCategory0 = "INFO";
                $logCategory1 = "WARNING";
                $description = "";
                $username = $_SESSION['username'];
                
                // IF REQUEST METHOD IS POST, NOT GET
                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    // Initialize variables
                    $errorMsg = "";
                    $success = true;

                    // PASSWORD VALIDATION FOR CURRENT PASWWORD (Required)
                    if (empty($_POST['pwd'])) {
                        $errorMsg .= "Please enter your current password.<br>";
                        $success = false;
                        $description = "FAILED USER ACCOUNT DEACTIVATION - CUSTOMER (PW-INPUT-ERR)";
                    }
                    // VALIDATING USING REGEX
                    else {
                        if (strlen($_POST['pwd']) < '12') {
                            $errorMsg = "Incorrect Password!<br>";
                            $description = "FAILED USER ACCOUNT DEACTIVATION - CUSTOMER (PW-INPUT-ERR)";
                            $success = false;
                        } elseif (!preg_match("#[0-9]+#", $_POST["pwd"])) {
                            $errorMsg = "Incorrect Password!<br>";
                            $description = "FAILED USER ACCOUNT DEACTIVATION - CUSTOMER (PW-INPUT-ERR)";
                            $success = false;
                        } elseif (!preg_match("#[A-Z]+#", $_POST["pwd"])) {
                            $errorMsg = "Incorrect Password!<br>";
                            $description = "FAILED USER ACCOUNT DEACTIVATION - CUSTOMER (PW-INPUT-ERR)";
                            $success = false;
                        } elseif (!preg_match("#[a-z]+#", $_POST["pwd"])) {
                            $errorMsg = "Incorrect Password!<br>";
                            $description = "FAILED USER ACCOUNT DEACTIVATION - CUSTOMER (PW-INPUT-ERR)";
                            $success = false;
                        }
                        // IF Passed REGEX validation, Cross check with DB for current password
                        else {
                            // HASH THE PASSWORD and check if it matches password in DB
                            $pwd_hashed = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
                            checkCurrentPwd($connect);
                            checkAccountBalance($connect);
                        }
                    }
                    
                    
                    // If Success, Deactive account and destroy session
                    if ($success) {
                        deactivateAccount($connect);
                        
                        unset($_SESSION["customerId"]);
                        unset($_SESSION['loggedin']);
                        //session_unset();
                        //session_destroy();
                        echo "<h3>Your account has been deactivated</h3><br>";
                        date_default_timezone_set('Asia/Singapore');
                        echo "<p class='h5'>" . date("Y/m/d") . " " . date("h:i:sa") . "</p><br>";
                        echo '<p class="h5"> Redirecting you to homepage... </p>';
                        header('Refresh: 10; URL=index.php');
                        echo "<p><button onclick='goHome()' class='btn btn-primary'>Home</button></p>";
                        echo "<br><br><br><br><br><br><br><br>";
                    }
                    // Else, show unsuccessful messages
                    else {
                        echo "<h3>Unsuccessful</h3>";
                        echo "<p class='h5'>The following errors were detected:</p>";
                        echo "<p style='color:red'>" . $errorMsg . "</p>";
                        echo "<p><button onclick='goBack()' class='btn btn-primary'>Back</button></p>";
                        echo "<br><br><br><br><br><br><br><br>";
                        
                        $failSql = $logSql;
                        $failLog = $connect->prepare($failSql);
                        $failLog->bindParam(1,$logType, PDO::PARAM_STR);
                        $failLog->bindParam(2,$logCategory1, PDO::PARAM_STR);
                        $failLog->bindParam(3,$description, PDO::PARAM_STR);
                        $failLog->bindParam(4,$username, PDO::PARAM_STR);
                        $failLog->execute();
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
            function checkCurrentPwd($connect) {
                global $pwd_hashed, $errorMsg, $success, $description;
                
                $id = $_SESSION["customerId"];
                // Prepare the statement:
                $getPwdSql = "SELECT `password_hash` FROM customer_credentials WHERE customer_id=?"; 
                $getPwdStmt = $connect->prepare($getPwdSql);
                $getPwdStmt->bindParam(1,$id, PDO::PARAM_INT);
                $getPwdStmt->execute();
                $getPwdResult = $getPwdStmt->fetchAll(PDO::FETCH_ASSOC);
                
                if($getPwdStmt->rowCount() == 1) {
                    $pwd_hashed = $getPwdResult[0]["password_hash"];
                    
                    // Check if current password user has entered == DB password
                    if (!password_verify($_POST["pwd"], $pwd_hashed)) {
                        $errorMsg = "Incorrect Password... Please enter current password to proceed";
                        $success = false;
                        $description = "FAILED USER ACCOUNT DEACTIVATION - CUSTOMER (PW-INPUT-INCORRECT)";
                    }
                }
                else {
                    $errorMsg = "Error, no data found";
                    $description = "FAILED USER ACCOUNT DEACTIVATION - CUSTOMER (PW-NOT-FOUND)";
                    $success = false;
                }
            }
            
            // Function to check if balance in all accounts is 0 before deactivation
            function checkAccountBalance($connect) {
                global $balance, $errorMsg, $success, $description;
                
                $id = $_SESSION["customerId"];
                // Prepare the statement:
                $getBalSql = "SELECT sum(balance) AS acc_sum FROM bank_account B, bank_accounts_ref R WHERE customer_id = ? AND B.account_id = R.account_id"; 
                $getBalStmt = $connect->prepare($getBalSql);
                $getBalStmt->bindParam(1,$id, PDO::PARAM_INT);
                $getBalStmt->execute();
                $getBalResult = $getBalStmt->fetchAll(PDO::FETCH_ASSOC);
                
                $balance = $getBalResult[0]["acc_sum"];
                if ($balance > 0.00) {
                    $errorMsg = "You have outstanding balance in your accounts, please head down to the bank to process deactivation.";
                    $success = false;
                    $description = "FAILED USER ACCOUNT DEACTIVATION - CUSTOMER (EXISTING-BANK-FUNDS)";
                }
            }
            
            // Function to deactivate account
            function deactivateAccount($connect) {
                global $active, $errorMsg, $success, $logSql, $logType, $logCategory0, $logCategory1, $username;
                
                $id = $_SESSION["customerId"];
                $active = 0;
                // Prepare the statement:
                $deactivateAccSql = "UPDATE customer_credentials SET active=? WHERE customer_id=?"; 
                $deactivateAccStmt = $connect->prepare($deactivateAccSql);
                $deactivateAccStmt->bindParam(1,$active, PDO::PARAM_INT);
                $deactivateAccStmt->bindParam(2,$id, PDO::PARAM_INT);
                $deactivateAccStmt->execute();
                $deactivateAccResult = $deactivateAccStmt->fetchAll(PDO::FETCH_ASSOC);
                
                if ($deactivateAccStmt->rowCount() != 1) {
//                    $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                    $errorMsg = "Deactivation failed. Please try again later.";
                    $success = false;
                    
                    $failSql = $logSql;
                    $description = "FAILED USER ACCOUNT DEACTIVATION - CUSTOMER (DB-FAIL)";
                    $failLog = $connect->prepare($failSql);
                    $failLog->bindParam(1,$logType, PDO::PARAM_STR);
                    $failLog->bindParam(2,$logCategory1, PDO::PARAM_STR);
                    $failLog->bindParam(3,$description, PDO::PARAM_STR);
                    $failLog->bindParam(4,$username, PDO::PARAM_STR);
                    $failLog->execute();
                }
                else {
                    $successSql = $logSql;
                    $description = "USER ACCOUNT DEACTIVATION - CUSTOMER (SUCCESS)";
                    $successLog = $connect->prepare($successSql);
                    $successLog->bindParam(1,$logType, PDO::PARAM_STR);
                    $successLog->bindParam(2,$logCategory0, PDO::PARAM_STR);
                    $successLog->bindParam(3,$description, PDO::PARAM_STR);
                    $successLog->bindParam(4,$username, PDO::PARAM_STR);
                    $successLog->execute();
                }
            }
            ?>

        </div>
    </div>
</div>
</div>
</body>
</html>