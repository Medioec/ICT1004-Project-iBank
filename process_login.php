<?php
$email = $pwd_hashed = $errorMsg = "";
$success = true;


if ($_SERVER["REQUEST_METHOD"] == "POST") {

//email
    if (empty($_POST["email"])) {
        $errorMsg .= "Email is required.<br>";
        $success = false;
    } else {
        $email = sanitize_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMsg .= "Invalid email format.<br>";
            $success = false;
        }
    }

//pass
    if (empty($_POST["pwd"])) {
        $errorMsg .= "Password and confirmation are required.<br>";
        $success = false;
    } 
 
    //Validation and sanitization is successful , run savemember to post to DB
    if ($success == true) {
        authenticateUser();
    }
}
/*
* Helper function to authenticate the login.
*/
function authenticateUser()
{
    global $fname, $lname, $email, $pwd_hashed, $errorMsg, $success;
    
    // Create database connection.
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'],
            $config['password'], $config['dbname']);

    // Check connection
    if ($conn->connect_error)
    {
        $errorMsg = "Connection failed: " . $conn->connect_error;
        $success = false;
    }
    else
    {
    // Prepare the statement:
    $stmt = $conn->prepare("SELECT * FROM world_of_pets_members WHERE email=?");

    // Bind & execute the query statement: 
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0)
    {
        // Note that email field is unique, so should only have 
        // one row in the result set.
        $row = $result->fetch_assoc();
        $fname = $row["fname"];
        $lname = $row["lname"];
        $pwd_hashed = $row["password"];
        
        // Check if the password matches:
        if (!password_verify($_POST["pwd"], $pwd_hashed))
        {
            // Don't be too specific with the error message - hackers don't 
            // need to know which one they got right or wrong. :) 
            $errorMsg = "Email not found or password doesn't match...";
            $success = false;
            
        }    
    }
        else 
        {
            $errorMsg = "Email not found or password doesn't match...";
            $success = false;
        }
        $stmt->close();
        }
        $conn->close();
}
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<html>
    <head>
        <title>Login Results</title>
        <?php
        include "head.inc.php";
        ?>
    </head>
    <body>
        <?php
        include "nav.inc.php";
        ?>
        <main class="container">
            <hr>
            <?php
            if ($success) {
                echo "<h2>Login successful!</h2>";
                echo "<h4>Welcome back " . $lname . ". </h4>";
                echo "<a class='btn btn-success' href='index.php'>Home</a>";
            } else {
                echo "<h2>Oops!</h2>";
                echo "<h4>The following errors were detected:</h4>";
                echo "<p>" . $errorMsg . "</p>";
                echo "<a class='btn btn-danger' href='login.php'>Return to Login</a>";
            }
            ?>
        </main>
        <?php
        include "footer.inc.php";
        ?>
    </body>
</html>