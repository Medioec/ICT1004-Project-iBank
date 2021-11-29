<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function phpMailerOTP($userEmail, $userName, $rndno) {
    //Load Composer's autoloader
    require '/var/www/phpmailer/vendor/autoload.php';
    //echo "script start";

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    //From email address and name
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';

    /* Username (email address). */
    $mail->Username = 'double04bank@gmail.com';

    /* Google account password. */
    $mail->Password = 'longlongpassword123456';

    //To address and name
    $mail->addAddress($userEmail); //Recipient name is optional

    //Address to which recipient will reply
    //$mail->addReplyTo('double04bank@gmail.com', "Reply");

    //CC and BCC
    //$mail->addCC("cc@example.com");
    //$mail->addBCC("bcc@example.com");

    //Send HTML or Plain Text email
    $mail->isHTML(true);

    $mail->Subject = "Double' o4 Bank OTP";	
    $mail->Body = "<h2>Hey there!</h2> "
            . "<p>Please enter this One-Time Password in the 2FA page.</p>"
            . "<p>Username:".$userName."</p>"
            . "<p>OTP:".$rndno."</p>";
    $mail->AltBody = "Hey there, please enter this One-Time Password in the 2FA page. Your Username:".$userName."; OTP:".$rndno."";
    
    $success = false;
    try {
        $mail->send();
        $success = true;
        //echo "Message has been sent successfully";
    } catch (Exception $e) {
        $success = false;
        //echo "Mailer Error: " . $mail->ErrorInfo;
    }
    return $success;
}

function phpMailerRegistration($email, $lname) {
    //Load Composer's autoloader
    require '/var/www/phpmailer/vendor/autoload.php';
    //echo "script start";

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    //From email address and name
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';

    /* Username (email address). */
    $mail->Username = 'double04bank@gmail.com';

    /* Google account password. */
    $mail->Password = 'longlongpassword123456';

    //To address and name
    $mail->addAddress($email); //Recipient name is optional

    //Address to which recipient will reply
    //$mail->addReplyTo('double04bank@gmail.com', "Reply");

    //Send HTML or Plain Text email
    $mail->isHTML(true);

    $mail->Subject = "Double' o4 Bank Member Registration";
    $mail->Body = "<h2>Hey there, " . $lname . "!</h2> "
            . "<p>Registration Sucessful</p>"
            . "<p>You're now a member of Double '04 Bank.</p>";
    $mail->AltBody = "Registration successful";
    
    $success = false;
    try {
        $mail->send();
        $success = true;
        //echo "Message has been sent successfully";
    } catch (Exception $e) {
        $success = false;
        //echo "Mailer Error: " . $mail->ErrorInfo;
    }
    return $success;
}

function phpMailerPwd($userEmail, $userName, $token, $url) {
    //Load Composer's autoloader
    require '/var/www/phpmailer/vendor/autoload.php';
    //echo "script start";

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    //From email address and name
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';

    /* Username (email address). */
    $mail->Username = 'double04bank@gmail.com';

    /* Google account password. */
    $mail->Password = 'longlongpassword123456';

    //To address and name
    $mail->addAddress($userEmail); //Recipient name is optional

    //Address to which recipient will reply
    //$mail->addReplyTo('double04bank@gmail.com', "Reply");

    //CC and BCC
    //$mail->addCC("cc@example.com");
    //$mail->addBCC("bcc@example.com");

    //Send HTML or Plain Text email
    $mail->isHTML(true);

    $mail->Subject = "Double' o4 Bank Password Reset";
    $mail->Body = "<h2>Hey there!</h2> "
            . "<p>Please use this link to reset your password.</p>"
			. "<p> Username: ".$userName . "</p>"
            . "<p>Password Reset Link: " . $url . "?token=" . $token . "</p>";
    $mail->AltBody = "Hey there! Please use this link to reset your password. Username: ".$userName . " Password Reset Link: " . $url . "?token=" . $token;
    
    $success = false;
    try {
        $mail->send();
        $success = true;
        //echo "Message has been sent successfully";
    } catch (Exception $e) {
        $success = false;
        //echo "Mailer Error: " . $mail->ErrorInfo;
    }
    return $success;
}
?>
