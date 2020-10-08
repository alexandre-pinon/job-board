<?php
    header("Content-Type: application/json; charset=UTF-8");
   
    include_once '../database/connect_db.php';
    include_once '../api/advertisements.php';

    $database = new Database();
    $db = $database->getConnection();

    $items = new Advertisement($db);
    $stmt = $items->getAdvertisements();

    if($stmt->rowCount() > 0) {

        $advertisementArr = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $e = array(
                "id" => $id,
                "title" => $title,
                "description" => $description,
                "contract_type" => $contract_type,
                "starting_date" => $starting_date,
                "min_salary" => $min_salary,
                "max_salary" => $max_salary,
                "localisation" => $localisation,
                "study_level" => $study_level,
                "experience_years" => $experience_years,
                "company_id" => $company_id
            );

            array_push($advertisementArr, $e);
        }
        echo json_encode($advertisementArr, JSON_PRETTY_PRINT);

    }

    else {
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>
