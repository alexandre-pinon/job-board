<?php
    /** Functions to filter user inputs **/
    
    function filterName($fname, $lname) {
        // Sanitize user name
        $fname = filter_var(trim($fname), FILTER_SANITIZE_STRING);
        $lname = filter_var(trim($lname), FILTER_SANITIZE_STRING);
        
        // Validate user name
        if(
            filter_var($fname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/"))) and
            filter_var($lname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))
        ) {
            $name = $fname." ".$lname;
            return $name;
        } else {
            return FALSE;
        }
    }

    function filterPassword($password) {
        // Sanitize password
        $password = filter_var(trim($password), FILTER_SANITIZE_STRING);

        // Validate password
        if(strlen($password) < 6 or strlen($password) > 100) {
            return FALSE;
        } else {
            return $password;
        }
    }

    function filterConfirmPassword($password, $confirmPassword) {
        // Sanitize confirm password
        $confirmPassword = filter_var(trim($confirmPassword), FILTER_SANITIZE_STRING);

        // Validate password
        if($password != $confirmPassword) {
            return FALSE;
        } else {
            return $confirmPassword;
        }
    }

    function filterEmail($email) {
        // Sanitize e-mail address
        $email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
        
        // Validate e-mail address
        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $email;
        } else {
            return FALSE;
        }
    }

    function filterPhoneNumber($phone) {
        // Sanitize phone number
        $phone = filter_var(trim($phone), FILTER_SANITIZE_NUMBER_INT);

        // Validate phone number
        if(strlen($phone) !== 10) {
            return FALSE;
        } else {
            return $phone;
        }
    }

    function filterString($string) {
        // Sanitize string
        $string = filter_var(trim($string), FILTER_SANITIZE_STRING);

        // Validate string
        if(!empty($string)) {
            return $string;
        } else {
            return FALSE;
        }
    }
?>