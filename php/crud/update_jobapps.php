<?php
    header("Access-Control-Allow-Origin: *");
    //header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../database/connect_db.php';
    include_once '../api/job_applications.php';
    
    $database = new Database();
    $db = $database->getConnection();
    
    $item = new JobApplication($db);
    
    $data = json_decode(file_get_contents("php://input"));
    
    $item->id = $data->id;
    
    // advertisements values
    $item->user_id = $data->user_id;
    $item->advertisement_id = $data->advertisement_id;
    $item->name = $data->name;
    $item->email = $data->email;
    $item->phone = $data->phone;
    $item->cv = $data->cv;
    $item->message = $data->message;
    
    // 
    if($item->updateJobApplication()){
        echo json_encode("Job Application data updated.");
    } else{
        echo json_encode("Data could not be updated");
    }
?>