<?php
session_start();
ob_start();
?>

<html>
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
        . "<h4>An error were detected: %s</h4>"
        . "<p>Please contact an administrator for help.</p>"
        . "<p>Redirecting back to Login page. Click on the button if the page does not redirect.</p>"
        . "<a class='btn btn-danger' href='login.php'>Return to Login</a>";

include_once ('php/connect.php');


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
                $pwSql = "SELECT `password_hash`, `active` FROM `customer_credentials` "
                        . "WHERE `customer_id` = (SELECT `customer_id` FROM `customer_credentials` "
                        . "WHERE `customer_username` = ?)"; 
                $pwStmt = $connect->prepare($pwSql);
                $pwStmt->bindParam(1,$thisusername, PDO::PARAM_STR);
                $pwStmt->execute();
                $pwResult = $pwStmt->fetchAll(PDO::FETCH_ASSOC);
                if(password_verify($thispassword, $pwResult[0]['password_hash']) && $pwResult[0]['active']=="1") {
                    
                    $successSql = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM','LOGIN - CUSTOMER (PW-TRUE)',?,CURRENT_TIMESTAMP)";
                    $successLog = $connect->prepare($successSql);
                    $successLog->bindParam(1,$thisusername, PDO::PARAM_STR);
                    $successLog->execute();

                    $emailSql = "SELECT `email`, `last_name` FROM `user_data` "
                            . "WHERE `customer_id` = (SELECT `customer_id` FROM `customer_credentials` "
                            . "WHERE `customer_username` = ?)";
                    $emailStmt = $connect->prepare($emailSql);
                    $emailStmt->bindParam(1,$thisusername, PDO::PARAM_STR);
                    $emailStmt->execute();
                    $emailResult = $emailStmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    if(isset($emailResult[0]['email'])) {
                        $lname = $emailResult[0]['last_name'];
                        include_once ('php/sendmail.php');
                        $rndno = rand(100000, 999999);
                        if (phpMailerOTP($emailResult[0]['email'], $thisusername, $rndno)) {
                            // Success
                            $otpSql = "UPDATE `customer_credentials` SET `otp`= ? "
                                    . "WHERE `customer_username` = ?";
                            $otpStmt = $connect->prepare($otpSql);
                            $otpStmt->bindParam(1,$rndno, PDO::PARAM_STR);
                            $otpStmt->bindParam(2,$thisusername, PDO::PARAM_STR);
                            $otpStmt->execute();
                            
                            $_SESSION['username'] = $thisusername;
                            $_SESSION['loggedin'] = "0";
                            
                            echo "<h2>Redirecting to OTP</h2>";
                            echo "<h4>Click on the button if the page does not redirect.</h4>";
                            echo "<a class='btn btn-success' href='otp.php'>OTP</a>";
                            
                            header('Refresh: 3; URL=otp.php');
                            //echo "<script>window.location.replace('otp.php');</script>";
                        }
                        else {
                            echo sprintf($errorMsg,"Invalid Email");
                            $failSql = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM',' FAILED LOGIN - CUSTOMER (Invalid email address)',?,CURRENT_TIMESTAMP)";
                            $failLog = $connect->prepare($failSql);
                            $failLog->bindParam(1,$thisusername, PDO::PARAM_STR);
                            $failLog->execute();
                            
                            header('Refresh: 3; URL=login.php');
                            //echo "<script>window.location.href = 'login.php';</script>";
                        }
                    }
                    else {
                        echo sprintf($errorMsg,"Invalid Email");
                        $failSql = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM',' FAILED LOGIN - CUSTOMER (No email address)',?,CURRENT_TIMESTAMP)";
                        $failLog = $connect->prepare($failSql);
                        $failLog->bindParam(1,$thisusername, PDO::PARAM_STR);
                        $failLog->execute();
                        
                        header('Refresh: 3; URL=login.php');
                        //echo "<script>window.location.href = 'login.php';</script>";
                    }
                }
                else {
                    echo sprintf($errorMsg,"Incorrect Username or Password");
                    $failSql = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM',' FAILED LOGIN - CUSTOMER (Invalid username or password)',?,CURRENT_TIMESTAMP)";
                    $failLog = $connect->prepare($failSql);
                    $failLog->bindParam(1,$thisusername, PDO::PARAM_STR);
                    $failLog->execute();
                    
                    header('Refresh: 3; URL=login.php');
                    //echo "<script>window.location.href = 'login.php';</script>";
                }
        }
        else {
            echo sprintf($errorMsg,"reCaptcha Error");
            $failSql = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM',' FAILED LOGIN - CUSTOMER (reCaptcha)',?,CURRENT_TIMESTAMP)";
            $failLog = $connect->prepare($failSql);
            $failLog->bindParam(1,$thisusername, PDO::PARAM_STR);
            $failLog->execute();
            
            header('Refresh: 3; URL=login.php');
            //echo "<script>window.location.href = 'login.php';</script>";
        }
    }
}
else {
    echo sprintf($errorMsg,"Invalid User");
    $failSql = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM',' FAILED LOGIN - CUSTOMER','-EMPTY FIELD-',CURRENT_TIMESTAMP)";
    $failLog = $connect->prepare($failSql);
    $failLog->execute();
    
    header('Refresh: 3; URL=login.php');
    //echo "<script>window.location.href = 'login.php';</script>";
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
                    include "footer.inc.php";
                ?>
            </main>
        </div>
    </body>
</html>