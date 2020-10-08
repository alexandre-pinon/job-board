<?php
    header("Content-Type: application/json; charset=UTF-8");
   
    include_once '../database/connect_db.php';
    include_once '../api/users.php';

    $database = new Database();
    $db = $database->getConnection();

    $items = new User($db);
    $stmt = $items->getUsers();

    if($stmt->rowCount() > 0) {

        $userArr = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $e = array(
                "id" => $id,
                "name" => $name,
                "email" => $email,
                "phone" => $phone,
                "password" => $password,
                "profile" => $profile,
                "cv" => $cv
            );

            array_push($userArr, $e);
        }
        echo json_encode($userArr, JSON_PRETTY_PRINT);

    }

    else {
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>
