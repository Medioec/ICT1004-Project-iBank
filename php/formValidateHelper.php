<?php
    $_SESSION["originTransactionPage"] = $_SERVER['REQUEST_URI'];

    
    //Displays error message if $_POST["inputInvalid"] is set
    function genericValidate() {
        if($_SESSION["inputInvalid"] == 1) {
        echo "
            <p class='error-msg text-danger'>Invalid input. Please check the input fields for errors.</p>
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
