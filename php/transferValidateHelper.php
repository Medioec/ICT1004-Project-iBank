<?php
    $_SESSION["verifyTransfer"] = 0;

    if($_SESSION["inputInvalid"] == 1)
    {
        echo "
            <p class='error-msg'>Invalid input. Please check the input fields for errors.</p>
        ";
        $_SESSION["inputInvalid"] = 0;
    }
    if($_SESSION["inputInvalid"] == 2)
    {
        echo "
            <p class='error-msg'>Insufficient funds in your account.</p>
        ";
        $_SESSION["inputInvalid"] = 0;
    }
?>
