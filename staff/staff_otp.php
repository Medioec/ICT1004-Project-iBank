<?php 
include_once ('connect.php');
session_start();
ob_start();

if(isset($_SESSION['otp'])){
    if($_SESSION['otp'] == "1"){
        header("url=staff_home.php");
    }
}
?>
<!-- Default HTML structure -->

<html>
    <?php
        include "staff_head.inc.php";
    ?>
    <body>
        <?php
            include "staff_nav.inc.php";
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
    return $data;
}
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

$tryBody = "<p class='h4'>Please enter the OTP sent to your registered email address.<p>";
$retryBody = "<div class=\"alert alert-success\" role=\"alert\">An email has been resent to your email address.</div>"
            . "<p class='h4'>Please enter the OTP sent to your registered email address.<p>";
$failBody = "<p class='h4'>The OTP is incorrect.<p><p class='h4'>Please enter the OTP sent to your registered email address.<p>";

// Error message for sprintf with %s as error parameter.
$errorMsg = "<h2>Oops!</h2>"
        . "<p class='h4'>An error were detected: %s<p>"
        . "<p>Please contact your superior for assistance.</p>"
        . "<p>Redirecting back to Login page. Click on the button if the page does not redirect.</p>"
        . "<a class='btn btn-danger' href='staff_login.php'>Return to Login</a>";

if (isset($_SESSION['staff_loggedin']) && $_SESSION['staff_loggedin'] == 1) {
    echo "<script>window.location.href = 'staff_home.php';</script>";
}
else if (isset($_SESSION['staff_username'])) {
	$session_user = $_SESSION['staff_username'];
        $activeSql = "SELECT `active` FROM `staff_credentials` WHERE `staff_username` = ?";
	$activeStmt = $connect->prepare($activeSql);
        $activeStmt->bindParam(1,$session_user, PDO::PARAM_STR);
        $activeStmt->execute();
        $activeResult = $activeStmt->fetchAll(PDO::FETCH_ASSOC);
}

if(($activeResult[0]['active'] == "0") || (!isset($activeResult[0]['active']))) {
    header('URL=staff_login.php');
}

echo "<html oncontextmenu='return false'>";    

$logSql = "INSERT INTO `log`(`type`,`category`, `description`, `user_performed`, `timestamp`) VALUES (?,?,?,?,CURRENT_TIMESTAMP)";
$logType = "OTP";
$logCategory0 = "INFO";
$logCategory1 = "WARNING";
$description = "";

if (isset($_POST['try'])) {
	$patternNumeric = '/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\]+[A-Za-z]/';
	if (!preg_match($patternNumeric, $_POST['otp'])) {
            
            $thisotp = sanitize_input($_POST['otp']);
            $otpSql = "SELECT `otp`,`staff_id`,`full_name` FROM `staff_credentials` WHERE `staff_username` = ?";
            $otpStmt = $connect->prepare($otpSql);
            $otpStmt->bindParam(1,$session_user, PDO::PARAM_STR);
            $otpStmt->execute();
            $otpResult = $otpStmt->fetchAll(PDO::FETCH_ASSOC);
            if($thisotp == $otpResult[0]['otp']) {
                // $otpSuccess = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM','LOGIN - STAFF (OTP-TRUE)',?,CURRENT_TIMESTAMP)";
                $otpSuccess = $logSql;
                $description = "LOGIN - STAFF (OTP-TRUE)";
                $otpSuccessStmt = $connect->prepare($otpSuccess);
                $otpSuccessStmt->bindParam(1,$logType, PDO::PARAM_STR);
                $otpSuccessStmt->bindParam(2,$logCategory0, PDO::PARAM_STR);
                $otpSuccessStmt->bindParam(3,$description, PDO::PARAM_STR);
                $otpSuccessStmt->bindParam(4,$session_user, PDO::PARAM_STR);
                $otpSuccessStmt->execute();
                
                $_SESSION['staff_otp'] = "1";
                $_SESSION['staff_loggedin'] = "1";
                $_SESSION['staffId'] = $otpResult[0]['staff_id'];
                
                echo "<h2>Redirecting to Homepage</h2>";
                echo "<p class='h4'>Click on the button if the page does not redirect.<p>";
                echo "<a class='btn btn-success' href='staff_home.php'>Homepage</a>";
                
                $_SESSION["displayName"] = $otpResult[0]['full_name'];
                
                header('Refresh: 3; URL=staff_home.php');
                //echo "<script>window.location.href = 'staff_home.php';</script>";
            }
            else {
                echo sprintf($otpBody,$failBody);
            }
	}
	else {
            echo "<center>Special Character found in One Time Password!</center>";
            
            // $otpFail = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM','FAILED LOGIN - STAFF (Special Character appeared OTP)',?,CURRENT_TIMESTAMP)";
            $failSql = $logSql;
            $description = "FAILED LOGIN - STAFF (Special Character appeared OTP)";
            $failLog = $connect->prepare($failSql);
            $failLog->bindParam(1,$logType, PDO::PARAM_STR);
            $failLog->bindParam(2,$logCategory1, PDO::PARAM_STR);
            $failLog->bindParam(3,$description, PDO::PARAM_STR);
            $failLog->bindParam(4,$session_user, PDO::PARAM_STR);
            $failLog->execute();
            
            header('Refresh: 5;');
            //echo "<script>window.location.href = 'staff_login.php';</script>";
	}
}
else if(isset($_POST['retry'])) {
    $emailSql = "SELECT `email`, FROM `staff_credentials` "
            . "WHERE `staff_username` = ?)";
    $emailStmt = $connect->prepare($emailSql);
    $emailStmt->bindParam(1,$session_user, PDO::PARAM_STR);
    $emailStmt->execute();
    $emailResult = $emailStmt->fetchAll(PDO::FETCH_ASSOC);

    if(isset($emailResult[0]['email'])) {
        include_once ('sendmail.php');
        $rndno=rand(100000, 999999);
        if (phpMailerOTP($emailResult[0]['email'], $session_user, $rndno)) {
            // Success
            $otpSql = "UPDATE `staff_credentials` SET `otp`= ? "
                    . "WHERE `staff_username` = ?";
            $otpStmt = $connect->prepare($otpSql);
            $otpStmt->bindParam(1,$rndno, PDO::PARAM_STR);
            $otpStmt->bindParam(2,$session_user, PDO::PARAM_STR);
            $otpStmt->execute();
            echo sprintf($otpBody,$retryBody);
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
            $failLog->bindParam(4,$session_user, PDO::PARAM_STR);
            $failLog->execute();

            header('Refresh: 5; URL=staff_login.php');
            //echo "<script>window.location.href = 'staff_login.php';</script>";
        }
    }
    else
    {
        echo sprintf($errorMsg,"Invalid Email");
        // $failSql = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM','FAILED LOGIN - STAFF (No email address)',?,CURRENT_TIMESTAMP)";
        $failSql = $logSql;
        $description = "FAILED LOGIN - STAFF (No email address)";
        $failLog = $connect->prepare($failSql);
        $failLog->bindParam(1,$logType, PDO::PARAM_STR);
        $failLog->bindParam(2,$logCategory1, PDO::PARAM_STR);
        $failLog->bindParam(3,$description, PDO::PARAM_STR);
        $failLog->bindParam(4,$session_user, PDO::PARAM_STR);
        $failLog->execute();

        header('Refresh: 5; URL=staff_login.php');
        //echo "<script>window.location.href = 'staff_login.php';</script>";
    }
}
else {
    echo sprintf($otpBody,$tryBody);
}
?>

                    </div>
                </div>
            <?php
               include "staff_footer.inc.php";
            ?>
            </main>
    </body>
</html>