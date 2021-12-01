<?php
session_start();
ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<html>
    <head>
        <title>Login Results</title>
        <?php
        include "staff_head.inc.php";
        ?>
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <?php
        include "staff_nav.inc.php";
        ?>
        <div class="page-bg"></div>
            <main class="page-body">
                <div class="page-content">
                    <div class="main-content">

<?php
include_once ('recaptchalib.php');

$secret = "6Lcj-EQUAAAAAD-ujIV87baNc6XHVg0VpPqaabxc";
$response = null;
$reCaptcha = new ReCaptcha($secret);

// Error message for sprintf with %s as error parameter.
$errorMsg = "<h2>Oops!</h2>"
        . "<p class='h4'>An error were detected: %s</p>"
        . "<p>Please contact an administrator for help.</p>"
        . "<p>Redirecting back to Login page. Click on the button if the page does not redirect.</p>"
        . "<a class='btn btn-danger' href='staff_login.php'>Return to Login</a>";

include_once ('connect.php');

$logSql = "INSERT INTO `log`(`type`,`category`, `description`, `user_performed`, `timestamp`) VALUES (?,?,?,?,CURRENT_TIMESTAMP)";
$logType = "LOGIN-STAFF";
$logCategory0 = "INFO";
$logCategory1 = "WARNING";
$description = "";
$noUser = "-EMPTY FIELD-";

if (isset($_POST['username'])) {
    $thisusername = sanitize_input($_POST['username']);
    if (isset($_POST['submit'])) {
        if ($_POST["g-recaptcha-response"]) {
            $response = $reCaptcha->verifyResponse(
                $_SERVER["REMOTE_ADDR"],
                $_POST["g-recaptcha-response"]
            );
        }
        
        if ($response != null && $response->success) {
                $thispassword = $_POST['password'];
                $pwSql = "SELECT `password_hash`, `active` FROM `staff_credentials` "
                        . "WHERE `staff_username` = ?"; 
                $pwStmt = $connect->prepare($pwSql);
                $pwStmt->bindParam(1,$thisusername, PDO::PARAM_STR);
                $pwStmt->execute();
                $pwResult = $pwStmt->fetchAll(PDO::FETCH_ASSOC);

                if(password_verify($thispassword, $pwResult[0]['password_hash']) && $pwResult[0]['active']=="1") {
                    
                    // $successSql = "INSERT INTO `log`(`type`,`category`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM','LOGIN - STAFF (PW-TRUE)',?,CURRENT_TIMESTAMP)";
                    $successSql = $logSql;
                    $description = "LOGIN - STAFF (PW-TRUE)";
                    $successLog = $connect->prepare($successSql);
                    $successLog->bindParam(1,$logType, PDO::PARAM_STR);
                    $successLog->bindParam(2,$logCategory0, PDO::PARAM_STR);
                    $successLog->bindParam(3,$description, PDO::PARAM_STR);
                    $successLog->bindParam(4,$thisusername, PDO::PARAM_STR);
                    $successLog->execute();

                    $emailSql = "SELECT `email`, `full_name` FROM `staff_credentials` "
                            . "WHERE `staff_username` = ?";
                    $emailStmt = $connect->prepare($emailSql);
                    $emailStmt->bindParam(1,$thisusername, PDO::PARAM_STR);
                    $emailStmt->execute();
                    $emailResult = $emailStmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    if(isset($emailResult[0]['email'])) {
                        include_once ('staff_sendmail.php');
                        $rndno = rand(100000, 999999);
                        if (phpMailerOTP($emailResult[0]['email'], $thisusername, $rndno)) {
                            // Success
                            $otpSql = "UPDATE `staff_credentials` SET `otp`= ? "
                                    . "WHERE `staff_username` = ?";
                            $otpStmt = $connect->prepare($otpSql);
                            $otpStmt->bindParam(1,$rndno, PDO::PARAM_STR);
                            $otpStmt->bindParam(2,$thisusername, PDO::PARAM_STR);
                            $otpStmt->execute();
                            
                            $_SESSION['staff_username'] = $thisusername;
                            $_SESSION['staff_loggedin'] = "0";
                            
                            echo "<h2>Redirecting to OTP</h2>";
                            echo "<p class='h4'>Click on the button if the page does not redirect.</p>";
                            echo "<a class='btn btn-success' href='staff_otp.php'>OTP</a>";
                            
                            header('Refresh: 3; URL=staff_otp.php');
                            //echo "<script>window.location.replace('staff_otp.php');</script>";
                        }
                        else {
                            echo sprintf($errorMsg,"Invalid Email");
                            // $failSql = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM','FAILED LOGIN - STAFF (Invalid email address)',?,CURRENT_TIMESTAMP)";
                            $failSql = $logSql;
                            $description = "FAILED LOGIN - STAFF (Invalid email address)";
                            $failLog = $connect->prepare($failSql);
                            $failLog->bindParam(1,$logType, PDO::PARAM_STR);
                            $failLog->bindParam(2,$logCategory1, PDO::PARAM_STR);
                            $failLog->bindParam(3,$description, PDO::PARAM_STR);
                            $failLog->bindParam(4,$thisusername, PDO::PARAM_STR);
                            $failLog->execute();
                            
                            header('Refresh: 5; URL=staff_login.php');
                            //echo "<script>window.location.href = 'staff_login.php';</script>";
                        }
                    }
                    else {
                        echo sprintf($errorMsg,"Invalid Email");
                        // $failSql = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM','FAILED LOGIN - STAFF (No email address)',?,CURRENT_TIMESTAMP)";
                        $failSql = $logSql;
                        $description = "FAILED LOGIN - STAFF (No email address)";
                        $failLog = $connect->prepare($failSql);
                        $failLog->bindParam(1,$logType, PDO::PARAM_STR);
                        $failLog->bindParam(2,$logCategory1, PDO::PARAM_STR);
                        $failLog->bindParam(3,$description, PDO::PARAM_STR);
                        $failLog->bindParam(4,$thisusername, PDO::PARAM_STR);
                        $failLog->execute();
                        
                        header('Refresh: 5; URL=staff_login.php');
                        //echo "<script>window.location.href = 'staff_login.php';</script>";
                    }
                }
                else {
                    echo sprintf($errorMsg,"Incorrect Username or Password");
                    // $failSql = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM','FAILED LOGIN - STAFF (Invalid username or password)',?,CURRENT_TIMESTAMP)";
                    $failSql = $logSql;
                    $description = "FAILED LOGIN - STAFF (Invalid username or password)";
                    $failLog = $connect->prepare($failSql);
                    $failLog->bindParam(1,$logType, PDO::PARAM_STR);
                    $failLog->bindParam(2,$logCategory1, PDO::PARAM_STR);
                    $failLog->bindParam(3,$description, PDO::PARAM_STR);
                    $failLog->bindParam(4,$thisusername, PDO::PARAM_STR);
                    $failLog->execute();
                    
                    header('Refresh: 5; URL=staff_login.php');
                    //echo "<script>window.location.href = 'staff_login.php';</script>";
                }
        }
        else {
            echo sprintf($errorMsg,"reCaptcha Error");
            // $failSql = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM','FAILED LOGIN - STAFF (reCaptcha)',?,CURRENT_TIMESTAMP)";
            $failSql = $logSql;
            $description = "FAILED LOGIN - STAFF (reCaptcha)";
            $failLog = $connect->prepare($failSql);
            $failLog->bindParam(1,$logType, PDO::PARAM_STR);
            $failLog->bindParam(2,$logCategory1, PDO::PARAM_STR);
            $failLog->bindParam(3,$description, PDO::PARAM_STR);
            $failLog->bindParam(4,$thisusername, PDO::PARAM_STR);
            $failLog->execute();
            
            header('Refresh: 5; URL=staff_login.php');
            //echo "<script>window.location.href = 'staff_login.php';</script>";
        }
    }
}
else {
    echo sprintf($errorMsg,"Invalid User");
    // $failSql = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM','FAILED LOGIN - STAFF','-EMPTY FIELD-',CURRENT_TIMESTAMP)";
    $failSql = $logSql;
    $description = "FAILED LOGIN - STAFF";
    $failLog = $connect->prepare($failSql);
    $failLog->bindParam(1,$logType, PDO::PARAM_STR);
    $failLog->bindParam(2,$logCategory1, PDO::PARAM_STR);
    $failLog->bindParam(3,$description, PDO::PARAM_STR);
    $failLog->bindParam(4,$noUser, PDO::PARAM_STR);
    $failLog->execute();
    
    header('Refresh: 5; URL=staff_login.php');
    //echo "<script>window.location.href = 'staff_login.php';</script>";
}
//$connect->close();

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
                    </div>
                </div>
                <?php
                    include "staff_footer.inc.php";
                ?>
            </main>
        </div>
    </body>
</html>