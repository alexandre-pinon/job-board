<?php
    header("Access-Control-Allow-Origin: *");
    //header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../config/database.php';
    include_once '../companies.php';

    $database = new Database();
    $db = $database->getConnection();

    $item = new Company($db);

    $data = json_decode(file_get_contents("php://input"));

    $item->name = $data->name;
    $item->logo = $data->logo;
    $item->background = $data->background;
    
    if($item->createCompany()){
        echo 'Company created successfully.';
    } else{
        echo 'Company could not be created.';
    }
?>