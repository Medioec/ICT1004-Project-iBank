<?php 
include_once ('php/connect.php');
session_start();
ob_start();

if(isset($_SESSION['otp'])){
    if($_SESSION['otp'] == "1"){
        header("url=index.php");
    }
}
?>
<!-- Default HTML structure -->
<!DOCTYPE html>
<html lang="en">
    <?php
        include "head.inc.php";
    ?>
    <body>
        <?php
            include "nav.inc.php";
        ?>
        <div class="page-bg"></div>
            <main class="page-body">
                <div class="page-content">
                    <div class="main-content">

<!-- Default HTML structure -->

<?php
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = htmlentities($data);
    return $data;
}
// Default OTP HTML elements
$otpBody = "<h2>One-Time Password (OTP)</h2>%s"
            . "<p>Please check your Spam folder if the email is not found.</p>"
            . "<form method='post'>" 
                . "<div class='form-group'>"
                    ."<label for='otp'>OTP:</label>"
                    ."<input class='form-control' type='text' id='otp' min='100000' max='999999' pattern='[0-9]{0.6}' required name='otp' size='6' placeholder='OTP'>"
                ."</div>"
                ."<div class='form-group'>"
                    ."<button class= 'btn btn-primary' type='submit' name='try'>Submit</button>"
                ."</div>"
            ."</form>"
            ."<form method='post'>"
                ."<div class='form-group'>"
                    ."<button class= 'btn btn-primary' type='submit' name='retry'>Send OTP again</button>"
                ."</div>"
            ."</form>";

// HTML elements to insert into %s
$tryBody = "<p class='h4'>Please enter the OTP sent to your registered email address.</p>";
$retryBody = "<div class=\"alert alert-success\" role=\"alert\">An email has been resent to your email address.</div>"
            . "<p class='h4'>Please enter the OTP sent to your registered email address.</p>";
$failBody = "<p class='h4'>The OTP is incorrect.<p><p class='h4'>Please enter the OTP sent to your registered email address.</p>";

// Error message for sprintf with %s as error parameter.
$errorMsg = "<h2>Oops!</h2>"
        . "<p class='h4'>An error were detected: %s</p>"
        . "<p>Please contact an administrator for help.</p>"
        . "<p>Redirecting back to Login page. Click on the button if the page does not redirect.</p>"
        . "<a class='btn btn-danger' href='login.php'>Return to Login</a>";

// If previously logged in, send to home page
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1) {
    echo "<script>window.location.href = 'index.php';</script>";
}
// Check user active status
else if (isset($_SESSION['username'])) {
    $session_user = $_SESSION['username'];
    $activeSql = "SELECT `active` FROM `customer_credentials` WHERE `customer_username` = ?";
    $activeStmt = $connect->prepare($activeSql);
    $activeStmt->bindParam(1,$session_user, PDO::PARAM_STR);
    $activeStmt->execute();
    $activeResult = $activeStmt->fetchAll(PDO::FETCH_ASSOC);
}

// If not active, send to front page
if(($activeResult[0]['active'] == "0") || (!isset($activeResult[0]['active']))) {
    header('URL=index.php');
}

echo "<html oncontextmenu='return false'>";    

// Logging Variables
$logSql = "INSERT INTO `log`(`type`,`category`, `description`, `user_performed`, `timestamp`) VALUES (?,?,?,?,CURRENT_TIMESTAMP)";
$logType = "OTP";
$logCategory0 = "INFO";
$logCategory1 = "WARNING";
$description = "";

// First time submit OTP for checking
if (isset($_POST['try'])) {
        // Ensure only numeric character
	$patternNumeric = '/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\]+[A-Za-z]/';
	if (!preg_match($patternNumeric, $_POST['otp'])) {
            
            // Remove symbols are unwanted characters
            $thisotp = sanitize_input($_POST['otp']);
            
            // Verify OTP submitted with OTP in DB
            $otpSql = "SELECT `otp`,`customer_id` FROM `customer_credentials` WHERE `customer_username` = ?";
            $otpStmt = $connect->prepare($otpSql);
            $otpStmt->bindParam(1,$session_user, PDO::PARAM_STR);
            $otpStmt->execute();
            $otpResult = $otpStmt->fetchAll(PDO::FETCH_ASSOC);
            // If OTP verifed
            if($thisotp == $otpResult[0]['otp']) {
                // $otpSuccess = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM','LOGIN - CUSTOMER (OTP-TRUE)',?,CURRENT_TIMESTAMP)";
                $otpSuccess = $logSql;
                $description = "LOGIN - CUSTOMER (OTP-TRUE)";
                $otpSuccessStmt = $connect->prepare($otpSuccess);
                $otpSuccessStmt->bindParam(1,$logType, PDO::PARAM_STR);
                $otpSuccessStmt->bindParam(2,$logCategory0, PDO::PARAM_STR);
                $otpSuccessStmt->bindParam(3,$description, PDO::PARAM_STR);
                $otpSuccessStmt->bindParam(4,$session_user, PDO::PARAM_STR);
                $otpSuccessStmt->execute();
                
                // Session variables set
                $_SESSION['otp'] = "1";
                $_SESSION['loggedin'] = "1";
                $_SESSION['customerId'] = $otpResult[0]['customer_id'];
                
                // Echo success message
                echo "<h2>Redirecting to Homepage</h2>";
                echo "<p class='h4'>Click on the button if the page does not redirect.</p>";
                echo "<a class='btn btn-success' href='index.php'>Homepage</a>";
                
                // Log in
                header('Refresh: 3; URL=index.php');
                //echo "<script>window.location.href = 'index.php';</script>";

                //get customer name
                $action = 'SELECT `first_name`, `last_name` FROM `user_data` WHERE `customer_id` = ?;';
                $stmt = $connect->prepare($action);
                $stmt->bindParam(1, $_SESSION["customerId"], PDO::PARAM_STR);
                try {
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
                catch(PDOException $e) {
                    //echo "Retrieve failed: " . $e->getMessage();
                }
                
                // Session variables set for display name
                $_SESSION["firstName"] = sanitize_input($result[0]['first_name']);
                $_SESSION["lastName"] = sanitize_input($result[0]['last_name']);
                
                // get customer gender for salutation title
                $action = 'SELECT `gender` FROM `sensitive_info` WHERE `customer_id`= ?;';
                $stmt = $connect->prepare($action);
                $stmt->bindParam(1, $_SESSION["customerId"], PDO::PARAM_STR);
                try {
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
                catch(PDOException $e) {
                    //echo "Retrieve failed: " . $e->getMessage();
                }
                
                // Get gender for salutations
                $_SESSION["gender"] = sanitize_input($result[0]['gender']);
                
                // Set firstName is display name, else last name as display name
                if ($_SESSION["firstName"]) {
                    $_SESSION["displayName"] = $_SESSION["firstName"];
                } else {
                    $_SESSION["displayName"] = $_SESSION["lastName"];
                }
                
            }
            else {
                echo sprintf($otpBody,$failBody);
            }
	}
        // Below are the failed attempt(s) and their logging
	else {
            echo "<center>Special Character found in One Time Password!</center>";
            
            // $otpFail = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM','FAILED LOGIN - CUSTOMER (Special Character appeared OTP)',?,CURRENT_TIMESTAMP)";
            $failSql = $logSql;
            $description = "FAILED LOGIN - CUSTOMER (Special Character appeared OTP)";
            $failLog = $connect->prepare($failSql);
            $failLog->bindParam(1,$logType, PDO::PARAM_STR);
            $failLog->bindParam(2,$logCategory1, PDO::PARAM_STR);
            $failLog->bindParam(3,$description, PDO::PARAM_STR);
            $failLog->bindParam(4,$session_user, PDO::PARAM_STR);
            $failLog->execute();
            
            header('Refresh: 5;');
            //echo "<script>window.location.href = 'login.php';</script>";
	}
}
// Send OTP again
else if(isset($_POST['retry'])) {
    // Resend OTP email
    $emailSql = "SELECT `email`, `last_name` FROM `user_data` "
            . "WHERE `customer_id` = (SELECT `customer_id` FROM `customer_credentials` "
            . "WHERE `customer_username` = ?)";
    $emailStmt = $connect->prepare($emailSql);
    $emailStmt->bindParam(1,$session_user, PDO::PARAM_STR);
    $emailStmt->execute();
    $emailResult = $emailStmt->fetchAll(PDO::FETCH_ASSOC);
    
    // If email exists
    if(isset($emailResult[0]['email'])) {
        $lname = $emailResult[0]['last_name'];
        include_once ('php/sendmail.php');
        $rndno=rand(100000, 999999);
        // If email sent successfully
        if (phpMailerOTP($emailResult[0]['email'], $session_user, $rndno)) {
            // Success
            $otpSql = "UPDATE `customer_credentials` SET `otp`= ? "
                    . "WHERE `customer_username` = ?";
            $otpStmt = $connect->prepare($otpSql);
            $otpStmt->bindParam(1,$rndno, PDO::PARAM_STR);
            $otpStmt->bindParam(2,$session_user, PDO::PARAM_STR);
            $otpStmt->execute();
            echo sprintf($otpBody,$retryBody);
        }
        // Below are the failed attempt(s) and their logging
        else {
            // If email sent unsuccessfully
            echo sprintf($errorMsg,"Invalid Email");
            // $failSql = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM','FAILED LOGIN - CUSTOMER (Invalid email address)',?,CURRENT_TIMESTAMP)";
            $failSql = $logSql;
            $description = "FAILED LOGIN - CUSTOMER (Invalid email address)";
            $failLog = $connect->prepare($failSql);
            $failLog->bindParam(1,$logType, PDO::PARAM_STR);
            $failLog->bindParam(2,$logCategory1, PDO::PARAM_STR);
            $failLog->bindParam(3,$description, PDO::PARAM_STR);
            $failLog->bindParam(4,$session_user, PDO::PARAM_STR);
            $failLog->execute();

            header('Refresh: 5; URL=login.php');
            //echo "<script>window.location.href = 'login.php';</script>";
        }
    }
    else
    {
        echo sprintf($errorMsg,"Invalid Email");
        // $failSql = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM','FAILED LOGIN - CUSTOMER (No email address)',?,CURRENT_TIMESTAMP)";
        $failSql = $logSql;
        $description = "FAILED LOGIN - CUSTOMER (No email address)";
        $failLog = $connect->prepare($failSql);
        $failLog->bindParam(1,$logType, PDO::PARAM_STR);
        $failLog->bindParam(2,$logCategory1, PDO::PARAM_STR);
        $failLog->bindParam(3,$description, PDO::PARAM_STR);
        $failLog->bindParam(4,$session_user, PDO::PARAM_STR);
        $failLog->execute();

        header('Refresh: 5; URL=login.php');
        //echo "<script>window.location.href = 'login.php';</script>";
    }
}
else {
    echo sprintf($otpBody,$tryBody);
}
?>

                    </div>
                </div>
            </main>
            <?php include "footer.inc.php";?>
    </body>
</html>-->