<!-- Default HTML structure -->
<html lang="en">
    <?php
        include "head.inc.php";
    ?>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
ob_start();
include_once ('php/connect.php');
include_once ('php/recaptchalib.php');

$secret = "6Lcj-EQUAAAAAD-ujIV87baNc6XHVg0VpPqaabxc";
$response = null;
$reCaptcha = new ReCaptcha($secret);

$forgetPasswordBody = "<h2>Forget Password</h2>"
                    . "<form method=\"post\">"
                        . "<div class=\"form-group\">"
                            . "<label for=\"email\">"
                                . "<p class='h4'>Please enter your email:<p>"
                            . "</label>"
                            . "<p>%s</p>"
                            . "<input class=\"form-control\" type=\"email\"  name=\"email\" required size=\"100\" "
                                . "maxlength=\"100\" placeholder=\"Email\">"
                        . "</div> "
                        . "<div class=\"form-group\">"
                            . "<div class=\"g-recaptcha\" data-sitekey=\"6Lcj-EQUAAAAAOR5N9iKG3EUYwJGecrPrCl4rJrc\"></div>"
                        . "</div>"
                        . "<div class=\"form-group\">"
                            . "<button class= \"btn btn-primary\" type=\"submit\" name=\"try\">Send Password Reset Email</button>"
                        . "</div>"
                        . "<a class= \"btn btn-secondary submit-button\" href=\"login.php\">Go to Login Page</a>"
                    . "</form>";

$message = "";

$logSql = "INSERT INTO `log`(`type`,`category`, `description`, `user_performed`, `timestamp`) VALUES (?,?,?,?,CURRENT_TIMESTAMP)";
$logType = "FORGET-PW";
$logCategory0 = "INFO";
$logCategory1 = "WARNING";
$description = "";
$noUser = "-EMPTY FIELD-";

if (isset($_POST['try'])) {
    if (isset($_POST['email'])) {
        if ($_POST["g-recaptcha-response"]) {
            $response = $reCaptcha->verifyResponse(
                $_SERVER["REMOTE_ADDR"],
                $_POST["g-recaptcha-response"]
            );
        }
        if ($response != null && $response->success) {
            $email = sanitize_input($_POST["email"]);

            $getInfoSql = "SELECT `customer_id`,`customer_username`,`active` FROM `customer_credentials` "
                    . "WHERE `customer_id` = "
                    . "(SELECT `customer_id` FROM `user_data` WHERE `email` = ?)";
            $getInfoStmt = $connect->prepare($getInfoSql);
            $getInfoStmt->bindParam(1,$email, PDO::PARAM_STR);
            $getInfoStmt->execute();
            $getInfoResult = $getInfoStmt->fetchAll(PDO::FETCH_ASSOC);
            $thisusername = $getInfoResult[0]['customer_username'];
            $thisuserid = $getInfoResult[0]['customer_id'];
            
            include_once ('php/sendmail.php');
            
            if ($getInfoResult[0]['active'] == "1") {
                $rndno = rand(1, 9999999);
                $token = md5($rndno);
                
                $url = "http://".$_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
                // Changes "http://[url]/forget_password.php" to "http://[url]/reset_password.php"
                $url = str_replace("forget_password","reset_password",$url);
                
                if (phpMailerPwd($email, $thisusername, $token, $url)) {
                    // Success
                    $tokenSql = "UPDATE `customer_credentials` SET `password_token`= ? "
                            . "WHERE `customer_id` = ?";
                    $tokenStmt = $connect->prepare($tokenSql);
                    $tokenStmt->bindParam(1,$token, PDO::PARAM_STR);
                    $tokenStmt->bindParam(2,$thisuserid, PDO::PARAM_STR);
                    $tokenStmt->execute();
                    
                    // $successSql = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM','PASSWORD RESET - CUSTOMER (EMAIL SENT)',?,CURRENT_TIMESTAMP)";
                    $successSql = $logSql;
                    $description = "PASSWORD RESET - CUSTOMER (EMAIL SENT)";
                    $successLog = $connect->prepare($successSql);
                    $successLog->bindParam(1,$logType, PDO::PARAM_STR);
                    $successLog->bindParam(2,$logCategory0, PDO::PARAM_STR);
                    $successLog->bindParam(3,$description, PDO::PARAM_STR);
                    $successLog->bindParam(4,$thisusername, PDO::PARAM_STR);
                    $successLog->execute();
                }
                else {
                    // $failSql = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM','FAILED PASSWORD RESET - CUSTOMER (Invalid email address)',?,CURRENT_TIMESTAMP)";
                    $failSql = $logSql;
                    $description = "FAILED PASSWORD RESET - CUSTOMER (Invalid email address)";
                    $failLog = $connect->prepare($failSql);
                    $failLog->bindParam(1,$logType, PDO::PARAM_STR);
                    $failLog->bindParam(2,$logCategory1, PDO::PARAM_STR);
                    $failLog->bindParam(3,$description, PDO::PARAM_STR);
                    $failLog->bindParam(4,$thisusername, PDO::PARAM_STR);
                    $failLog->execute();
                }
            }
            $message = "<div class=\"alert alert-success\" role=\"alert\">Email sent.</div>";
        }
        else {
            $message = "<div class=\"alert alert-warning\" role=\"alert\">reCaptcha Error</div>";
            // $failSql = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM',' FAILED PASSWORD RESET - CUSTOMER (reCaptcha)','-EMPTY FIELD-',CURRENT_TIMESTAMP)";
            $failSql = $logSql;
            $description = "FAILED PASSWORD RESET - CUSTOMER (reCaptcha)";
            $failLog = $connect->prepare($failSql);
            $failLog->bindParam(1,$logType, PDO::PARAM_STR);
            $failLog->bindParam(2,$logCategory1, PDO::PARAM_STR);
            $failLog->bindParam(3,$description, PDO::PARAM_STR);
            $failLog->bindParam(4,$noUser, PDO::PARAM_STR);
            $failLog->execute();
        }
    }
    else {
        $message = "<div class=\"alert alert-warning\" role=\"alert\">Invalid Input</div>";
        // $failSql = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM',' FAILED PASSWORD RESET - CUSTOMER (reCaptcha)','-INVALID FIELD-',CURRENT_TIMESTAMP)";
        $failSql = $logSql;
        $description = "FAILED PASSWORD RESET - CUSTOMER (reCaptcha)";
        $failLog = $connect->prepare($failSql);
        $failLog->bindParam(1,$logType, PDO::PARAM_STR);
        $failLog->bindParam(2,$logCategory1, PDO::PARAM_STR);
        $failLog->bindParam(3,$description, PDO::PARAM_STR);
        $failLog->bindParam(4,$noUser, PDO::PARAM_STR);
        $failLog->execute();
    }
}

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$forgetPasswordBody = sprintf($forgetPasswordBody,$message);
echo $forgetPasswordBody;

?>
<!-- Default HTML structure -->
                    </div>
                </div>
            <?php
               include "footer.inc.php";
            ?>
            </main>
    </body>
</html>
<!-- Default HTML structure -->