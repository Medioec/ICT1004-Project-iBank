<?php
    function sanitize_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    function checkValidNum($data) {
        if(!preg_match("/^[0-9-]*+$/", $data)){ //lazy check to check for digits and dashes only
            return 1;
        }
    }
?>