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

<html>
    <?php
        include "head.inc.php";
    ?>
    <body>
        <?php
            include "nav.inc.php";
        ?>
        <link rel="stylesheet" href="css/main.css">
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
            . "<form method=\"post\">" 
                . "<div class=\"form-group\">"
                    ."<label for=\"otp\">OTP:</label>"
                    ."<input class=\"form-control\" type=\"text\" id=\"otp\" min=\"100000\" max=\"999999\" pattern=\"[0-9]{0.6}\" required name=\"otp\" size=\"6\" placeholder=\"OTP\">"
                ."</div>"
                ."<div class=\"form-group\">"
                    ."<button class= \"btn btn-primary\" type=\"submit\" name=\"try\">Submit</button>"
                ."</div>"
            ."</form>"
            ."<form method=\"post\">"
                ."<div class=\"form-group\">"
                    ."<button class= \"btn btn-primary\" type=\"submit\" name=\"retry\">Send OTP again</button>"
                ."</div>"
            ."</form>";

$tryBody = "<h4>Please enter the OTP sent to your registered email address.</h4>";
$retryBody = "<h4>An email has been resent to your email address.</h4><h4>Please enter the OTP sent to your registered email address.</h4>";
$failBody = "<h4>The OTP is incorrect.</h4><h4>Please enter the OTP sent to your registered email address.</h4>";

// Error message for sprintf with %s as error parameter.
$errorMsg = "<h2>Oops!</h2>"
        . "<h4>An error were detected: %s</h4>"
        . "<p>Please contact an administrator for help.</p>"
        . "<p>Redirecting back to Login page. Click on the button if the page does not redirect.</p>"
        . "<a class='btn btn-danger' href='login.php'>Return to Login</a>";

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1) {
    echo "<script>window.location.href = 'index.php';</script>";
}
else if (isset($_SESSION['username'])) {
	$session_user = $_SESSION['username'];
        $activeSql = "SELECT `active` FROM `customer_credentials` WHERE `customer_username` = ?";
	$activeStmt = $connect->prepare($activeSql);
        $activeStmt->bindParam(1,$session_user, PDO::PARAM_STR);
        $activeStmt->execute();
        $activeResult = $activeStmt->fetchAll(PDO::FETCH_ASSOC);
}

if(($activeResult[0]['active'] == "0") || (!isset($activeResult[0]['active']))) {
    header('URL=index.php');
}

echo "<html oncontextmenu=\"return false\">";                    
if (isset($_POST['try'])) {
	$patternNumeric = '/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\]+[A-Za-z]/';
	if (!preg_match($patternNumeric, $_POST['otp'])) {
            
            $thisotp = sanitize_input($_POST['otp']);
            $otpSql = "SELECT `otp`,`customer_id` FROM `customer_credentials` WHERE `customer_username` = ?";
            $otpStmt = $connect->prepare($otpSql);
            $otpStmt->bindParam(1,$session_user, PDO::PARAM_STR);
            $otpStmt->execute();
            $otpResult = $otpStmt->fetchAll(PDO::FETCH_ASSOC);
            if($thisotp == $otpResult[0]['otp']) {
                $otpSuccess = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM','LOGIN - CUSTOMER (OTP-TRUE)',?,CURRENT_TIMESTAMP)";
                $otpSuccessStmt = $connect->prepare($otpSuccess);
                $otpSuccessStmt->bindParam(1,$session_user, PDO::PARAM_STR);
                $otpSuccessStmt->execute();
                
                $_SESSION['otp'] = "1";
                $_SESSION['loggedin'] = "1";
                $_SESSION['customerId'] = $otpResult[0]['customer_id'];
                
                echo "<h2>Redirecting to Homepage</h2>";
                echo "<h4>Click on the button if the page does not redirect.</h4>";
                echo "<a class='btn btn-success' href='index.php'>Homepage</a>";
                
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
                
                $_SESSION["firstName"] = $result[0]['first_name'];
                $_SESSION["lastName"] = $result[0]['last_name'];
                
                //get customer gender for salutation title
                $action = 'SELECT `gender` FROM `sensitive_info` WHERE `ic_number` = '
                        . '(SELECT `ic_number` FROM `sensitive_ref` WHERE `customer_id`= ?);';
                $stmt = $connect->prepare($action);
                $stmt->bindParam(1, $_SESSION["customerId"], PDO::PARAM_STR);
                try {
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
                catch(PDOException $e) {
                    //echo "Retrieve failed: " . $e->getMessage();
                }
                
                $_SESSION["gender"] = $result[0]['gender'];

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
	else {
            echo "<center>Special Character found in One Time Password!</center>";
            
            $otpFail = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM','FAILED LOGIN - CUSTOMER (Special Character appeared OTP)',?,CURRENT_TIMESTAMP)";
            $otpFailStmt = $connect->prepare($otpSuccess);
            $otpFailStmt->bindParam(1,$session_user, PDO::PARAM_STR);
            $otpFailStmt->execute();
            
            header('Refresh: 3;');
            //echo "<script>window.location.href = 'login.php';</script>";
	}
}
else if(isset($_POST['retry'])) {
    $emailSql = "SELECT `email`, `last_name` FROM `user_data` "
            . "WHERE `customer_id` = (SELECT `customer_id` FROM `customer_credentials` "
            . "WHERE `customer_username` = ?)";
    $emailStmt = $connect->prepare($emailSql);
    $emailStmt->bindParam(1,$session_user, PDO::PARAM_STR);
    $emailStmt->execute();
    $emailResult = $emailStmt->fetchAll(PDO::FETCH_ASSOC);

    if(isset($emailResult[0]['email'])) {
        $lname = $emailResult[0]['last_name'];
        include_once ('php/sendmail.php');
        $rndno=rand(100000, 999999);
        if (phpMailer($emailResult[0]['email'], $session_user, $rndno)) {
            // Success
            $otpSql = "UPDATE `customer_credentials` SET `otp`= ? "
                    . "WHERE `customer_username` = ?";
            $otpStmt = $connect->prepare($otpSql);
            $otpStmt->bindParam(1,$rndno, PDO::PARAM_STR);
            $otpStmt->bindParam(2,$session_user, PDO::PARAM_STR);
            $otpStmt->execute();
            echo sprintf($otpBody,$retryBody);
        }
        else {
            echo sprintf($errorMsg,"Invalid Email");
            $failSql = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM',' FAILED LOGIN - CUSTOMER (Invalid email address)',?,CURRENT_TIMESTAMP)";
            $failLog = $connect->prepare($failSql);
            $failLog->bindParam(1,$session_user, PDO::PARAM_STR);
            $failLog->execute();

            header('Refresh: 3; URL=login.php');
            //echo "<script>window.location.href = 'login.php';</script>";
        }
    }
    else
    {
        echo sprintf($errorMsg,"Invalid Email");
        $failSql = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM',' FAILED LOGIN - CUSTOMER (No email address)',?,CURRENT_TIMESTAMP)";
        $failLog = $connect->prepare($failSql);
        $failLog->bindParam(1,$session_user, PDO::PARAM_STR);
        $failLog->execute();

        header('Refresh: 3; URL=login.php');
        //echo "<script>window.location.href = 'login.php';</script>";
    }
}
else {
    echo sprintf($otpBody,$tryBody);
}
?>

                    </div>
                </div>
            <?php
               include "footer.inc.php";
            ?>
            </main>
    </body>
</html>-->