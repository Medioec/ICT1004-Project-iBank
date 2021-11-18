<html>
    <head>
    <?php
    include "head.inc.php";
    ?>
    </head>
    <body>
        <?php
        include "nav.inc.php";
        ?>
        
        
        <?php
        // PDO
        include_once "connect.php";
        
        $query = $conn->prepare("SELECT * FROM user_data WHERE customer_id=?");
        $stmt = $connect->prepare($query);
        $stmt->bindParam(1, $customer_id, PDO::PARAM_INT);
        $stmt->bindParam(2,$fname, PDO::PARAM_STR);
        $stmt->bindParam(3,$lname, PDO::PARAM_STR);
        $stmt->bindParam(4,$fullname, PDO::PARAM_STR);
        $stmt->bindParam(5,$street1, PDO::PARAM_STR);
        $stmt->bindParam(6,$street2, PDO::PARAM_STR);
        $stmt->bindParam(7,$postal, PDO::PARAM_STR);
        $stmt->bindParam(8,$email, PDO::PARAM_STR);
        $stmt->bindParam(9,$phone, PDO::PARAM_STR);
        
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        ?>
        
        <?php
        // MYSQL
        global $fname, $lname, $fullname, $street1, $street2, $postal, $email, $phone, $errorMsg;
        
        // Create database connection.
        $config = parse_ini_file('../../private/db-config.ini');
        $conn = new mysqli($config['servername'], $config['username'],
                $config['password'], $config['dbname']);
        // Prepare the statement:
        $stmt = $conn->prepare("SELECT * FROM user_data WHERE customer_id=?");
        // Hard coded - TO CHANGE TO SESSION
        //$stmt->bind_param("s", $_SESSION[""]);
        $stmt->bind_param("i", 1);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $fname = $row["first_name"];
            $lname = $row["last_name"];
            $fullname = $row["full_name"];
            $street1 = $row["street1"];
            $street2 = $row["street2"];
            $postal = $row["postal"];
            $email = $row["email"];
            $phone = $row["phone"];
        }
        
        else 
        {
            $errorMsg = "User data not found";
            echo $errorMsg;
        }
        $stmt->close();
        $conn->close();
        ?>
        
        
        <div class="page-bg"></div>
            <main class="page-body">
                <div class="page-content">
                    <div class="main-content">
                       
                        <h1>Hello, <?php $_SESSION[''] ?></h1>

                        <form>
                            <h4>Basic Info</h4>
                            <div class="form-group">
                                <label for="fname">First name</label>
                                <input class="form-control" type="text" id="fname" required name="fname" value="<?php echo $fname ?>" disabled>
                            </div>
                            
                            <div class="form-group">
                                <label for="lname">Last name</label>
                                <input class="form-control" type="text" id="lname" required name="lname" value="<?php echo $lname ?>" disabled>
                            </div>

                            <div class="form-group">
                                <label for="lname">Full name</label>
                                <input class="form-control" type="text" id="fullname" required name="lname" value="<?php echo $fullname ?>" disabled>
                            </div>
                            
                            <div class="form-group">
                                <label for="street1">Street 1</label>
                                <input class="form-control" type="text" id="street1" required name="street1" value="<?php echo $street1 ?>" disabled>
                            </div>

                            <div class="form-group">
                                <label for="street2">Street 2</label>
                                <input class="form-control" type="text" id="street2" required name="street2" value="<?php echo $street2 ?>" disabled>
                            </div>
                            
                            <div class="form-group">
                                <label for="postal">Postal</label>
                                <input class="form-control" type="text" id="postal" required name="postal" value="<?php echo $postal ?>" disabled>
                            </div>
                            
                            <h4>Contact Info</h4>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input class="form-control" type="email" id="email" required name="email" value="<?php echo $email ?>" disabled>
                            </div>
                            
                            <div class="form-group">
                                <label for="postal">Phone</label>
                                <input class="form-control" type="text" id="phone" required name="phone" value="<?php echo $phone?>" disabled>
                            </div>
                            

                            <div class="form-group">
                            <button class= "btn btn-primary" type="button" onClick="location.href='./update_profile.php'">Update Details</button>
                            </div>
                        </form>
                    </div>
                </div>
                
            <?php
                include "footer.inc.php";
            ?>
            </main>
        
        <!-- Check if fname is empty -->
        <script>
            var hide = document.getElementById("fnamegroup");
            var input = document.getElementById("fname");
            if(input.value === ""){
                fnamegroup.style.display = "none";
            }
        </script>
        
        </div>
    </body>
</html>