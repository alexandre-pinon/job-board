<?php
    header("Content-Type: application/json; charset=UTF-8");
   
    include_once '../config/database.php';
    include_once '../job_applications.php';

    $database = new Database();
    $db = $database->getConnection();

    $items = new JobApplication($db);
    
    $stmt = $items->getJobApplications();
    $itemCount = $stmt->rowCount();

    //echo json_encode($itemCount);

    if($itemCount > 0) {

        $jobApplicationArr = array();
        $jobApplicationArr["body"] = array();
        $jobApplicationArr["itemCount"] = $itemCount;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $e = array(
                "id" => $id,
                "user_id" => $user_id,
                "advertisement_id" => $advertisement_id,
                "name" => $name,
                "email" => $email,
                "phone" => $phone,
                "cv" => $cv,
                "message" => $message
            );

            array_push($jobApplicationArr, $e);
        }
        echo json_encode($jobApplicationArr, JSON_PRETTY_PRINT);

    }

    else {
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>
