<?php
$fname = $lname = $email = $pwd_hashed = $errorMsg = "";
$success = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
//first
    if (!empty($_POST["fname"])) {
        $fname = sanitize_input($_POST["fname"]);
    }

//last
    if (empty($_POST["lname"])) {
        $errorMsg .= "Last name is required.<br>";
        $success = false;
    } else {
        $lname = sanitize_input($_POST["lname"]);
    }

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
    if (empty($_POST["pwd"]) || empty($_POST["pwd_confirm"])) {
        $errorMsg .= "Password and confirmation are required.<br>";
        $success = false;
    } else {
        if ($_POST["pwd"] != $_POST["pwd_confirm"]) {
            $errorMsg .= "Passwords do not match.<br>";
            $success = false;
        } else {
            $pwd_hashed = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
        }
    }
    if ($success == true) {
        saveMemberToDB();
    }
} else {
    echo "<h2>This page is not meant to be run directly. </h2>";
    echo "<p>You can reigster at the link below:</p>";
    echo "<a href='register.php'>Go to Sign Up page... </a>";
    exit();
}

//Helper function that checks input for malicious or unwanted content.
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function saveMemberToDB()
{
    global $fname, $lname, $email, $pwd_hashed, $errorMsg, $success;
    
    //Create database connection.
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
        $stmt = $conn->prepare("INSERT INTO world_of_pets_members (fname, lname, email, password) VALUES (?, ?, ?, ?)");
        
        // Bind & execute the query statement:
        $stmt->bind_param("ssss", $fname, $lname, $email, $pwd_hashed);
        if (!$stmt->execute())
        {
            $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            $success = false;
        }
        $stmt->close();
    }
    
    $conn->close();
}
?>

<html>
    <head>
        <title>Registration Results</title>
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
                echo "<h2>Your registration is successful!</h2>";
                echo "<h4>Thank you for signing up, " . $lname . ". </h4>";
                echo "<a class='btn btn-success' href='index.php'>Home</a>";
            } else {
                echo "<h2>Oops!</h2>";
                echo "<h4>The following errors were detected:</h4>";
                echo "<p>" . $errorMsg . "</p>";
                echo "<a class='btn btn-danger' href='register.php'>Return to Sign Up</a>";
            }
            ?>
        </main>
        <?php
        include "footer.inc.php";
        ?>
    </body>
</html>