<?php
    header("Content-Type: application/json; charset=UTF-8");
   
    include_once '../database/connect_db.php';
    include_once '../api/companies.php';

    $database = new Database();
    $db = $database->getConnection();

    $items = new Company($db);
    $stmt = $items->getCompanies();

    if($stmt->rowCount() > 0) {

        $companyArr = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $e = array(
                "id" => $id,
                "name" => $name,
                "logo" => $logo,
                "background" => $background
            );

            array_push($companyArr, $e);
        }
        echo json_encode($companyArr, JSON_PRETTY_PRINT);

    }

    else {
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>
