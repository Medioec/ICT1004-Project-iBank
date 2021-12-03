<?php
session_start();
// Instant Login for professors' viewing of internal webpages
$_SESSION['staff_username'] = "john";
$_SESSION['staff_otp'] = "1";
$_SESSION['staff_loggedin'] = "1";
$_SESSION['staffId'] = "1";
$_SESSION["position"] = "AUDITOR [For testing]";
$_SESSION["displayName"] = "John Tan";

echo "Entering as John (For professors' viewing)";

header('Refresh: 1; URL=staff_home.php');

?>
