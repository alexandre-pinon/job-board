<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");


    include_once '../config/database.php';
    include_once '../job_applications.php';

    $database = new Database();
    $db = $database->getConnection();

    $item = new JobApplication($db);

    $item->id = isset($_GET['id']) ? $_GET['id'] : die();
  
    $item->getSingleJobApplication();

    if($item->user_id != null){
        // create array
        $emp_arr = array(
            "id" =>  $item->id,
            "user_id" => $item->user_id,
            "advertisement_id" => $item->advertisement_id,
            "name" => $item->name,
            "email" => $item->email,
            "phone" => $item->phone,
            "cv" => $item->cv,
            "message" => $item->message
        );
      
        http_response_code(200);
        echo json_encode($emp_arr);
    }
      
    else{
        http_response_code(404);
        echo json_encode("Job Application not found.");
    }
?>