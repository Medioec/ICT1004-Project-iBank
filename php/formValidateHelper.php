<?php
    //Include in every banking page that has a possibility of setting account IDs etc. to reduce chances of abuse
    //Reason: to ensure transfer_confirm.php can only be accessed through transfer pages
    $_SESSION["originTransactionPage"] = $_SERVER['REQUEST_URI'];

    
    //Displays error message if $_POST["inputInvalid"] is set
    function genericValidate() {
        if($_SESSION["inputInvalid"] == 1) {
            if(isset($_SESSION["errormsg"])) {
                $errormsg = $_SESSION["errormsg"];
            } else {
                $errormsg = "Invalid input. Please check the input fields for errors.";
            }
        echo "
            <p class='error-msg text-danger'>".$errormsg."</p>
        ";
        $_SESSION["inputInvalid"] = 0;
        }
    }

    function balanceVaidate() {
        if($_SESSION["inputInvalid"] == 2) {
        echo "
            <p class='error-msg text-danger'>Insufficient funds in your account.</p>
        ";
        $_SESSION["inputInvalid"] = 0;
        }
    }

?>
