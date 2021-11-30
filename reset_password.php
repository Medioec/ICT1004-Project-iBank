<?php
ob_start();
?>

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
//session_start();
//ob_start();
include_once ('php/connect.php');

$resetPasswordBody = "<h2>An error has occurred.</h2>%s"
                    . "<div class=\"alert alert-danger\" role=\"alert\">Please contact an administrator for help.</div>"
                    . "<a class='btn btn-danger' href='index.php'>Homepage</a>";
$message = "";
if (isset($_GET['token']) && !empty($_GET['token'])) {
    $success = false;
    
    $token = $_GET['token'];
    
    $checkUserSql = "SELECT `customer_username`,`active` FROM `customer_credentials`"
            . "WHERE password_token = ?";
    $checkUserStmt = $connect->prepare($checkUserSql);
    $checkUserStmt->bindParam(1,$token, PDO::PARAM_STR);
    $checkUserStmt->execute();
    $checkUserResult = $checkUserStmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($checkUserResult[0]['active'] == "1") {
        $thisusername = $checkUserResult[0]['customer_username'];
        
        if (isset($_POST['try']) && isset($_POST['pwd']) && isset($_POST['cfm_pwd'])) {
            // PASSWORD VALIDATION FOR CURRENT PASWWORD (Required)
            if (empty($_POST['pwd'])) {
                $message .= "<div class=\"alert alert-warning\" role=\"alert\">Please set a password for your account.</div>";
                $success = false;
            }
            // VALIDATING USING REGEX
            else {
                $token = $_GET['token'];
                $pwd = $_POST['pwd'];
                $cfm_pwd = $_POST['cfm_pwd'];
                if (strlen($pwd) < '12') {
                    $message .= "<div class=\"alert alert-warning\" role=\"alert\">Password Must Contain At Least 12 Characters!</div>";
                    $success = false;
                } elseif (!preg_match("#[0-9]+#", $pwd)) {
                    $message .= "<div class=\"alert alert-warning\" role=\"alert\">Password Must Contain At Least 1 Number!</div>";
                    $success = false;
                } elseif (!preg_match("#[A-Z]+#", $pwd)) {
                    $message .= "<div class=\"alert alert-warning\" role=\"alert\">Password Must Contain At Least 1 Capital Letter!</div>";
                    $success = false;
                } elseif (!preg_match("#[a-z]+#", $pwd)) {
                    $message .= "<div class=\"alert alert-warning\" role=\"alert\">Password Must Contain At Least 1 Lowercase Letter!</div>";
                    $success = false;
                } elseif ($pwd !== $cfm_pwd) {
                    $message .= "<div class=\"alert alert-warning\" role=\"alert\">Password Does Not Match!</div>";
                    $success = false;
                }
                // IF Passed REGEX validation
                else {
                    // HASH THE PASSWORD and check if it matches password in DB
                    $pwd_hashed = password_hash($pwd, PASSWORD_DEFAULT);
                    $rndno = rand(1, 9999999);
                    $newtoken = md5($rndno);
                    $updatePwdSql = "UPDATE `customer_credentials` "
                            . "SET `password_hash` = ?, `password_token` = ? "
                            . "WHERE `customer_username` = ? AND `password_token` = ?";
                    $updatePwdStmt = $connect->prepare($updatePwdSql);
                    $updatePwdStmt->bindParam(1,$pwd_hashed, PDO::PARAM_STR);
                    $updatePwdStmt->bindParam(2,$newtoken, PDO::PARAM_STR);
                    $updatePwdStmt->bindParam(3,$thisusername, PDO::PARAM_STR);
                    $updatePwdStmt->bindParam(4,$token, PDO::PARAM_STR);
                    $updatePwdStmt->execute();
                    
                    $successSql = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM','PASSWORD RESET - CUSTOMER (SUCCESS)',?,CURRENT_TIMESTAMP)";
                    $successLog = $connect->prepare($successSql);
                    $successLog->bindParam(1,$thisusername, PDO::PARAM_STR);
                    $successLog->execute();
                    
                    $success = true;
                }
            }
            if (!$success) {
                $failSql = "INSERT INTO `log`(`type`, `description`, `user_performed`, `timestamp`) VALUES ('SYSTEM',' FAILED PASSWORD RESET - CUSTOMER (INVALID INPUT)',?,CURRENT_TIMESTAMP)";
                $failLog = $connect->prepare($failSql);
                $failLog->bindParam(1,$thisusername, PDO::PARAM_STR);
                $failLog->execute();
            }
        }
        if ($success) {
            $resetPasswordBody = "<h2>Password Reset</h2>"
                                . "%s"
                                . "<div class=\"alert alert-success\" role=\"alert\">"
                                    . "Success"
                                . "</div>"
                                . "<p>Redirecting back to Login page. Click on the button if the page does not redirect.</p>"
                                . "<a class='btn btn-primary' href='login.php'>Login</a>";
            
            header('Refresh: 3; URL=login.php');
        }
        else {
            $resetPasswordBody = "<h2>Reset Password</h2>"
                                . "%s"
                                . "<form method=\"post\">"
                                    . "<div class=\"form-group\">"
                                        . "<label for=\"pwd\">Set a new Password</label>"
                                        . "<input class=\"form-control\" type=\"password\" id=\"pwd\" name=\"pwd\" "
                                            . "placeholder=\"Enter a password for your account\" required>"
                                    . "</div>"
                                    . "<div class=\"form-group\">"
                                        . "<label for=\"pwd\">Confirm Password</label>"
                                        . "<input class=\"form-control\" type=\"password\" id=\"cfm_pwd\" name=\"cfm_pwd\" "
                                            . "placeholder=\"Re-enter your password\" required>"
                                    . "</div>"
                                    . "<div class=\"form-group\">"
                                        . "<button class= \"btn btn-primary\" type=\"submit\" name=\"try\">Change Password</button>"
                                    . "</div>"
                                . "</form>";
        }
    }
    

}

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$resetPasswordBody = sprintf($resetPasswordBody,$message);
echo $resetPasswordBody;

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