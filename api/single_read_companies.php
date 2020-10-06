<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");


    include_once '../config/database.php';
    include_once '../advertisements.php';

    $database = new Database();
    $db = $database->getConnection();

    $item = new Company($db);

    $item->id = isset($_GET['id']) ? $_GET['id'] : die();
  
    $item->getSingleCompany();

    if($item->title != null){
        // create array
        $emp_arr = array(
            "id" =>  $item->id,
            "name" => $item->name,
            "logo" => $item->logo,
            "background" => $item->background
        );
      
        http_response_code(200);
        echo json_encode($emp_arr);
    }
      
    else{
        http_response_code(404);
        echo json_encode("Company not found.");
    }
?>