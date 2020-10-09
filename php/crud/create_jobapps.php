<?php
    header("Access-Control-Allow-Origin: *");
    //header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../database/connect_db.php';
    include_once '../api/job_applications.php';
    include_once '../filters/filter_jobapps.php';

    // Define variables and initialize with empty values
    $nameErr = $emailErr = $phoneErr = $messageErr = $cvErr = "";
    $name = $email = $phone = $message = $cv = $advertisement_id = "";

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
                $phoneErr = "Please enter a valid phone number. (10 numbers)";
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

        // Get Advertisement ID
        $advertisement_id = (int)$_POST["advertisement_id"];

        // Define Response
        $response = array(
            "nameErr"=>$nameErr,
            "emailErr"=>$emailErr,
            "phoneErr"=>$phoneErr,
            "messageErr"=>$messageErr,
            "cvErr"=>$cvErr
        );
        
        // If no input errors
        if (empty($nameErr) && empty($emailErr) && empty($phoneErr) && empty($messageErr) && empty($cvErr)) {
            // Attempt MySQL server connection
            $database = new Database();
            $db = $database->getConnection();

            $item = new JobApplication($db);

            // Set parameters
            $item->user_id = null;
            $item->advertisement_id = $advertisement_id;
            $item->name = $name;
            $item->email = $email;
            $item->phone = $phone;
            $item->cv = $cv;
            $item->message = $message;

            // Check if user already apply to the ad
            try {
                // Prepare an insert statement
                $sql = "SELECT * FROM job_application
                WHERE email = :email
                AND advertisement_id = :advertisement_id";

                $stmt_check = $db->prepare($sql);

                // Bind parameters to statement
                $stmt_check->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt_check->bindParam(':advertisement_id', $advertisement_id, PDO::PARAM_INT);

                // Execution
                $stmt_check->execute();
                if($stmt_check->rowCount() > 0) {
                    $response["apply_message"] = "You've already apply to this ad !";
                    $response["apply_success"] = TRUE;
                } else {
                    // Attempt to create job app
                    if($item->createJobApplication()){
                        $response["apply_message"] = 'Job Application created successfully.';
                        $response["apply_success"] = TRUE;
                    } else {
                        $response["apply_message"] = 'Job Application could not be created.';
                        $response["apply_success"] = FALSE;
                    }
                }
            } catch(PDOException $exception) {
                $response["apply_message"] = "ERROR 37";
                $response["apply_success"] = FALSE;
            }
        }
        header("content-type: application/json");
        echo json_encode($response);
    }
?>