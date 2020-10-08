<?php
    header("Access-Control-Allow-Origin: *");
    //header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../database/connect_db.php';
    include_once '../api/companies.php';
    
    $database = new Database();
    $db = $database->getConnection();
    
    $item = new Company($db);
    
    $data = json_decode(file_get_contents("php://input"));
    
    $item->id = $data->id;
    
    // advertisements values
    $item->name = $data->name;
    $item->logo = $data->logo;
    $item->background = $data->background;
    
    // 
    if($item->updateCompany()){
        echo json_encode("Company data updated.");
    } else{
        echo json_encode("Data could not be updated");
    }
?>