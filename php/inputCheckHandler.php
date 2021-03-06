<?php
    function sanitize_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    function checkValidNum($data) {
        if(!preg_match("/^[ 0-9-:]+$/", $data)){ //lazy check to check for digits, colon and dashes only
            {echo "invalid num";}
            return 1;
        }
    }
    function checkValidMoney($data) {
        if(!preg_match("/^[0-9]+.?[0-9]*$/", $data)){ //check for valid transfer amount
            return 1;
        }
    }
    function checkValidAlpha($data) {
        if(!preg_match("/^[a-zA-z]+[ a-zA-z]*$/", $data)) {
            return 1;
        }
    }
?>