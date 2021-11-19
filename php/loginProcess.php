<html>
    <head>
        <title>Login Results</title>
        <?php
        include "../head.inc.php";
        ?>
        <link rel="stylesheet" href="../css/main.css">
    </head>
    <body>
        <?php
        include "../nav.inc.php";
        ?>
        <div class="page-bg"></div>
            <main class="page-body">
                <div class="page-content">
                    <div class="main-content">

<?php
include_once ('recaptchalib.php');

session_start();

$secret = "6Lcj-EQUAAAAAD-ujIV87baNc6XHVg0VpPqaabxc";
$response = null;
$reCaptcha = new ReCaptcha($secret);

include_once ('connect.php');


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
                    echo "<center>Logging you in!</center><br>";

                    $_SESSION['username']=$thisusername;
                    $_SESSION['loggedin']="1";
                    
                    $successSql = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM','LOGIN - CUSTOMER',?,CURRENT_TIMESTAMP)";
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
                        include_once ('sendmail.php');
                        $rndno=rand(100000, 999999);
                        if (phpMailer($emailResult[0]['email'], $thisusername, $rndno)) {
                            // Success
                            $otpSql = "UPDATE `customer_credentials` SET `otp`= ? "
                                    . "WHERE `customer_username` = ?";
                            $otpStmt = $connect->prepare($otpSql);
                            $otpStmt->bindParam(1,$rndno, PDO::PARAM_STR);
                            $otpStmt->bindParam(2,$thisusername, PDO::PARAM_STR);
                            $otpStmt->execute();
                            echo "<h2>Redirecting to OTP</h2>";
                            echo "<h4>Click on the button if the page does not redirect.</h4>";
                            echo "<a class='btn btn-success' href='otp.php'>OTP</a>";
                            header( "refresh:3;url=../otp.php" );
                        }
                        else {
                            echo "<h2>Oops!</h2>";
                            echo "<h4>An error were detected: Invalid Email</h4>";
                            echo "<p>Please contact an administrator for help.</p>";
                            echo "<p>Redirecting back to Login page. Click on the button if the page does not redirect.</p>";
                            echo "<a class='btn btn-danger' href='../login.php'>Return to Login</a>";
                            $failSql = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM',' FAILED LOGIN - CUSTOMER (Invalid email address)',?,CURRENT_TIMESTAMP)";
                            $failLog = $connect->prepare($failSql);
                            $failLog->bindParam(1,$thisusername, PDO::PARAM_STR);
                            $failLog->execute();

                            header( "refresh:3;url=../login.php" );
                        }
                    }
                    else {
                        echo "<h2>Oops!</h2>";
                        echo "<h4>An error were detected: Invalid Email</h4>";
                        echo "<p>Please contact an administrator for help.</p>";
                        echo "<p>Redirecting back to Login page. Click on the button if the page does not redirect.</p>";
                        echo "<a class='btn btn-danger' href='../login.php'>Return to Login</a>";
                        $failSql = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM',' FAILED LOGIN - CUSTOMER (No email address)',?,CURRENT_TIMESTAMP)";
                        $failLog = $connect->prepare($failSql);
                        $failLog->bindParam(1,$thisusername, PDO::PARAM_STR);
                        $failLog->execute();

                        header( "refresh:3;url=../login.php" );
                    }
                }
                else {
                    echo "<h2>Oops!</h2>";
                    echo "<h4>An error were detected: Incorrect Username or Password</h4>";
                    echo "<p>Please contact an administrator for help.</p>";
                    echo "<p>Redirecting back to Login page. Click on the button if the page does not redirect.</p>";
                    echo "<a class='btn btn-danger' href='../login.php'>Return to Login</a>";
                    $failSql = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM',' FAILED LOGIN - CUSTOMER (Invalid username or password)',?,CURRENT_TIMESTAMP)";
                    $failLog = $connect->prepare($failSql);
                    $failLog->bindParam(1,$thisusername, PDO::PARAM_STR);
                    $failLog->execute();

                    header( "refresh:3;url=../login.php" );
                }
        }
        else {
            echo "<h2>Oops!</h2>";
            echo "<h4>An error were detected: reCaptcha Error</h4>";
            echo "<p>Please contact an administrator for help.</p>";
            echo "<p>Redirecting back to Login page. Click on the button if the page does not redirect.</p>";
            echo "<a class='btn btn-danger' href='../login.php'>Return to Login</a>";
            $failSql = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM',' FAILED LOGIN - CUSTOMER (reCaptcha)',?,CURRENT_TIMESTAMP)";
            $failLog = $connect->prepare($failSql);
            $failLog->bindParam(1,$thisusername, PDO::PARAM_STR);
            $failLog->execute();

            header( "refresh:3;url=../login.php" );
        }
    }
}
else {
    echo "<h2>Oops!</h2>";
    echo "<h4>An error were detected: Invalid User</h4>";
    echo "<p>Please contact an administrator for help.</p>";
    echo "<p>Redirecting back to Login page. Click on the button if the page does not redirect.</p>";
    echo "<a class='btn btn-danger' href='../login.php'>Return to Login</a>";
    $failSql = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM',' FAILED LOGIN - CUSTOMER','-EMPTY FIELD-',CURRENT_TIMESTAMP)";
    $failLog = $connect->prepare($failSql);
    $failLog->execute();

    header( "refresh:3;url=../login.php" );
}
$connect->close();

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