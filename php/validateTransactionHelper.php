<?php
    include_once "inputCheckHandler";
    $pageName = basename($_SERVER['PHP_SELF']);
    echo "
    <input type='hidden' name='pageName' value='".$pageName."'></input>
    ";
    $var = sanitize_input($_POST["inputInvalid"]);
    if($var == 1)
    {
        echo "
            <p>Invalid input. Please check the input fields for errors.</p>
        ";
    }
    if($var == 2)
    {
        echo "
            <p>Insufficient funds in your account.</p>
        ";
    }
?>
