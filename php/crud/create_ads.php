<?php
    header("Access-Control-Allow-Origin: *");
    //header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../database/connect_db.php';
    include_once '../api/advertisements.php';

    $database = new Database();
    $db = $database->getConnection();

    $item = new Advertisement($db);

    $data = json_decode(file_get_contents("php://input"));

    $item->title = $data->title;
    $item->description = $data->description;
    $item->contract_type = $data->contract_type;
    $item->starting_date = $data->starting_date;
    $item->min_salary = $data->min_salary;
    $item->max_salary = $data->max_salary;
    $item->localisation = $data->localisation;
    $item->study_level = $data->study_level;
    $item->experience_years = $data->experience_years;
    $item->company_id = $data->company_id;

    
    if($item->createAdvertisement()){
        echo 'Advertisement created successfully.';
    } else{
        echo 'Advertisement could not be created.';
    }
?>