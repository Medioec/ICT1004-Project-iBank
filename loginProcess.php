<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login Results</title>
        <?php
        include "head.inc.php";
        ?>
        <link rel="stylesheet" href="css/main.css">
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
include_once ('php/recaptchalib.php');

$secret = "6Lcj-EQUAAAAAD-ujIV87baNc6XHVg0VpPqaabxc";
$response = null;
$reCaptcha = new ReCaptcha($secret);

// Error message for sprintf with %s as error parameter.
$errorMsg = "<h2>Oops!</h2>"
        . "<p class='h4'>An error were detected: %s</p>"
        . "<p>Please contact an administrator for help.</p>"
        . "<p>Redirecting back to Login page. Click on the button if the page does not redirect.</p>"
        . "<a class='btn btn-danger' href='login.php'>Return to Login</a>";

include_once ('php/connect.php');

// Logging Variables
$logSql = "INSERT INTO `log`(`type`,`category`, `description`, `user_performed`, `timestamp`) VALUES (?,?,?,?,CURRENT_TIMESTAMP)";
$logType = "LOGIN";
$logCategory0 = "INFO";
$logCategory1 = "WARNING";
$description = "";
$noUser = "-EMPTY FIELD-";

// Check if username is set
if (isset($_POST['username'])) {
    // Convert symbols and special char to safe
    $thisusername = sanitize_input($_POST['username']);
    
    if (isset($_POST['submit'])) {
        // Check Google reCaptcha 
        if ($_POST["g-recaptcha-response"]) {
            $response = $reCaptcha->verifyResponse(
                $_SERVER["REMOTE_ADDR"],
                $_POST["g-recaptcha-response"]
            );
        }
        
        // Verify Google reCaptcha
        if ($response != null && $response->success) {
                $thispassword = $_POST['password'];
                // Get password hash from DB
                $pwSql = "SELECT `password_hash`, `active` FROM `customer_credentials` "
                        . "WHERE `customer_id` = (SELECT `customer_id` FROM `customer_credentials` "
                        . "WHERE `customer_username` = ?)"; 
                $pwStmt = $connect->prepare($pwSql);
                $pwStmt->bindParam(1,$thisusername, PDO::PARAM_STR);
                $pwStmt->execute();
                $pwResult = $pwStmt->fetchAll(PDO::FETCH_ASSOC);
                
                // Verify password hash
                if(password_verify($thispassword, $pwResult[0]['password_hash']) && $pwResult[0]['active']=="1") {
                    
                    // If successful verification
                    $successSql = $logSql;
                    $description = "LOGIN - CUSTOMER (PW-TRUE)";
                    $successLog = $connect->prepare($successSql);
                    $successLog->bindParam(1,$logType, PDO::PARAM_STR);
                    $successLog->bindParam(2,$logCategory0, PDO::PARAM_STR);
                    $successLog->bindParam(3,$description, PDO::PARAM_STR);
                    $successLog->bindParam(4,$thisusername, PDO::PARAM_STR);
                    $successLog->execute();
                    
                    // Get email and last name for OTP mail
                    $emailSql = "SELECT `email`, `last_name` FROM `user_data` "
                            . "WHERE `customer_id` = (SELECT `customer_id` FROM `customer_credentials` "
                            . "WHERE `customer_username` = ?)";
                    $emailStmt = $connect->prepare($emailSql);
                    $emailStmt->bindParam(1,$thisusername, PDO::PARAM_STR);
                    $emailStmt->execute();
                    $emailResult = $emailStmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    // If email exists
                    if(isset($emailResult[0]['email'])) {
                        $lname = $emailResult[0]['last_name'];
                        include_once ('php/sendmail.php');
                        $rndno = rand(100000, 999999);
                        
                        // If OTP email sent successfully
                        if (phpMailerOTP($emailResult[0]['email'], $thisusername, $rndno)) {
                            // Set OTP for verification
                            $otpSql = "UPDATE `customer_credentials` SET `otp`= ? "
                                    . "WHERE `customer_username` = ?";
                            $otpStmt = $connect->prepare($otpSql);
                            $otpStmt->bindParam(1,$rndno, PDO::PARAM_STR);
                            $otpStmt->bindParam(2,$thisusername, PDO::PARAM_STR);
                            $otpStmt->execute();
                            
                            // Set session variables 
                            $_SESSION['username'] = sanitize_input($thisusername);
                            $_SESSION['loggedin'] = "0";
                            
                            // Success message
                            echo "<h2>Redirecting to OTP</h2>";
                            echo "<p class='h4'>Click on the button if the page does not redirect.</p>";
                            echo "<a class='btn btn-success' href='otp.php'>OTP</a>";
                            
                            header('Refresh: 3; URL=otp.php');
                            //echo "<script>window.location.replace('otp.php');</script>";
                        }
                        // Below are the failed attempt(s) and their logging
                        else {
                            // If OTP email sent successfully
                            echo sprintf($errorMsg,"Invalid Email");
                            // $failSql = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM','FAILED LOGIN - CUSTOMER (Invalid email address)',?,CURRENT_TIMESTAMP)";
                            $failSql = $logSql;
                            $description = "FAILED LOGIN - CUSTOMER (Invalid email address)";
                            $failLog = $connect->prepare($failSql);
                            $failLog->bindParam(1,$logType, PDO::PARAM_STR);
                            $failLog->bindParam(2,$logCategory1, PDO::PARAM_STR);
                            $failLog->bindParam(3,$description, PDO::PARAM_STR);
                            $failLog->bindParam(4,$thisusername, PDO::PARAM_STR);
                            $failLog->execute();
                            
                            header('Refresh: 5; URL=login.php');
                            //echo "<script>window.location.href = 'login.php';</script>";
                        }
                    }
                    else {
                        echo sprintf($errorMsg,"Invalid Email");
                        // $failSql = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM','FAILED LOGIN - CUSTOMER (No email address)',?,CURRENT_TIMESTAMP)";
                        $failSql = $logSql;
                        $description = "FAILED LOGIN - CUSTOMER (No email address)";
                        $failLog = $connect->prepare($failSql);
                        $failLog->bindParam(1,$logType, PDO::PARAM_STR);
                        $failLog->bindParam(2,$logCategory1, PDO::PARAM_STR);
                        $failLog->bindParam(3,$description, PDO::PARAM_STR);
                        $failLog->bindParam(4,$thisusername, PDO::PARAM_STR);
                        $failLog->execute();
                        
                        header('Refresh: 5; URL=login.php');
                        //echo "<script>window.location.href = 'login.php';</script>";
                    }
                }
                else {
                    echo sprintf($errorMsg,"Incorrect Username or Password");
                    // $failSql = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM','FAILED LOGIN - CUSTOMER (Invalid username or password)',?,CURRENT_TIMESTAMP)";
                    $failSql = $logSql;
                    $description = "FAILED LOGIN - CUSTOMER (Invalid username or password)";
                    $failLog = $connect->prepare($failSql);
                    $failLog->bindParam(1,$logType, PDO::PARAM_STR);
                    $failLog->bindParam(2,$logCategory1, PDO::PARAM_STR);
                    $failLog->bindParam(3,$description, PDO::PARAM_STR);
                    $failLog->bindParam(4,$thisusername, PDO::PARAM_STR);
                    $failLog->execute();
                    
                    header('Refresh: 5; URL=login.php');
                    //echo "<script>window.location.href = 'login.php';</script>";
                }
        }
        else {
            echo sprintf($errorMsg,"reCaptcha Error");
            // $failSql = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM','FAILED LOGIN - CUSTOMER (reCaptcha)',?,CURRENT_TIMESTAMP)";
            $failSql = $logSql;
            $description = "FAILED LOGIN - CUSTOMER (reCaptcha)";
            $failLog = $connect->prepare($failSql);
            $failLog->bindParam(1,$logType, PDO::PARAM_STR);
            $failLog->bindParam(2,$logCategory1, PDO::PARAM_STR);
            $failLog->bindParam(3,$description, PDO::PARAM_STR);
            $failLog->bindParam(4,$thisusername, PDO::PARAM_STR);
            $failLog->execute();
            
            header('Refresh: 5; URL=login.php');
            //echo "<script>window.location.href = 'login.php';</script>";
        }
    }
}
else {
    echo sprintf($errorMsg,"Invalid User");
    // $failSql = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM','FAILED LOGIN - CUSTOMER','-EMPTY FIELD-',CURRENT_TIMESTAMP)";
    $failSql = $logSql;
    $description = "FAILED LOGIN - CUSTOMER";
    $failLog = $connect->prepare($failSql);
    $failLog->bindParam(1,$logType, PDO::PARAM_STR);
    $failLog->bindParam(2,$logCategory1, PDO::PARAM_STR);
    $failLog->bindParam(3,$description, PDO::PARAM_STR);
    $failLog->bindParam(4,$noUser, PDO::PARAM_STR);
    $failLog->execute();
    
    header('Refresh: 5; URL=login.php');
    //echo "<script>window.location.href = 'login.php';</script>";
}
//$connect->close();

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = htmlentities($data);
    return $data;
}
?>
                    </div>
                </div>
            </main>
            <?php include "footer.inc.php";?>
        </div>
    </body>
</html>