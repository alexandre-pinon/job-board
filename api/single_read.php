<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");


    include_once '../config/database.php';
    include_once '../advertisements.php';

    $database = new Database();
    $db = $database->getConnection();

    $item = new Advertisement($db);

    $item->id = isset($_GET['id']) ? $_GET['id'] : die();
  
    $item->getSingleAdvertisement();

    if($item->title != null){
        // create array
        $emp_arr = array(
            "id" =>  $item->id,
            "title" => $item->title,
            "description" => $item->description,
            "contract_type" => $item->contract_type,
            "starting_date" => $item->starting_date,
            "min_salary" => $item->min_salary,
            "max_salary" => $item->max_salary,
            "localisation" => $item->localisation,
            "study_level" => $item->study_level,
            "experience_years" => $item->experience_years,
            "company_id" => $item->company_id
        );
      
        http_response_code(200);
        echo json_encode($emp_arr);
    }
      
    else{
        http_response_code(404);
        echo json_encode("Advertisement not found.");
    }
?>