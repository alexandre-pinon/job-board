<?php
    // Functions to filter user inputs
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

    function filterEmail($email) {
        // Sanitize e-mail address
        $email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
        
        // Validate e-mail address
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            return $email;
        } else {
            return FALSE;
        }
    }

    function filterPhoneNumber($phone) {
        // Sanitize phone number
        $phone = filter_var(trim($phone), FILTER_SANITIZE_NUMBER_INT);

        // Validate phone number
        if(strlen($phone) < 10 or strlen($phone) > 14) {
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

    // Define variables and initialize with empty values
    $nameErr = $emailErr = $phoneErr = $messageErr = $cvErr = "";
    $name = $email = $phone = $message = $cv = "";

    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST") {

        // Validate user name
        if (empty($_POST["fname"]) and empty($_POST["lname"])) {
            $nameErr = "Please enter your name.";
        } else {
            $name = filterName($_POST["fname"], $_POST["lname"]);
            if($name == FALSE){
                $nameErr = "Please enter a valid name.";
            }
        }

        // Validate email address
        if (empty($_POST["email"])) {
            $emailErr = "Please enter your email address.";     
        } else {
            $email = filterEmail($_POST["email"]);
            if ($email == FALSE) {
                $emailErr = "Please enter a valid email address.";
            }
        }

        // Validate phone number
        if (empty($_POST["phone"])) {
            $phone = NULL;
        } else {
            $phone = filterPhoneNumber($_POST["phone"]);
            if ($phone == FALSE) {
                $phoneErr = "Please enter a valid phone number.";
            }
        }

        // Validate message
        if (empty($_POST["message"])) {
            $messageErr = "Please enter your message.";
        } else {
            $message = filterString($_POST["message"]);
            if ($message == FALSE) {
                $messageErr = "Please enter a valid message.";
            }
        }

        // Validate CV
        if (empty($_POST["cv"])) {
            $cv = NULL;
        } else {
            $cv = filterString($_POST["cv"]);
            if ($cv == FALSE) {
                $cvErr = "Please enter a valid cv.";
            }
        }

        // if(empty($nameErr) && empty($emailErr) && empty($phoneErr) && empty($messageErr) && empty($cvErr)) {
        //     /* Attempt MySQL server connection. Assuming you are running MySQL
        //     server with default setting (user 'root' with no password) */
        //     $mysqli = new mysqli("localhost", "admin", "admin", "jobboard");
            
        //     // Check connection
        //     if($mysqli === FALSE){
        //         die("ERROR: Could not connect. " . $mysqli->connect_error);
        //     }
            
        //     // Prepare an insert statement
        //     $sql = "INSERT INTO job_application (name, email, phone, message, cv) VALUES (?, ?, ?, ?, ?)";
            
        //     if($stmt = $mysqli->prepare($sql)){
        //         // Bind variables to the prepared statement as parameters
        //         $stmt->bind_param("ssiss", $DBname, $DBemail, $DBphone, $DBmessage, $DBcv);
                
        //         // Set parameters
        //         $DBname = $name;
        //         $DBemail = $email;
        //         $DBphone = $phone;
        //         $DBmessage = $message;
        //         $DBcv = $cv;
                
        //         // Attempt to execute the prepared statement
        //         $stmt->execute()
        //     }
            
        //     // Close statement
        //     $stmt->close();
            
        //     // Close connection
        //     $mysqli->close();
        // }

        $response = array("nameErr"=>$nameErr, "emailErr"=>$emailErr, "phoneErr"=>$phoneErr, "messageErr"=>$messageErr, "cvErr"=>$cvErr);
        header("content-type: application/json");
        echo json_encode($response);
    }
?>