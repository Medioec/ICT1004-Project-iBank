<?php
    $_SESSION["originTransactionPage"] = $_SERVER['REQUEST_URI'];

    if($_SESSION["inputInvalid"] == 1) {
        echo "
            <p class='error-msg'>Invalid input. Please check the input fields for errors.</p>
        ";
    }
    $_SESSION["inputInvalid"] = 0;
?>
