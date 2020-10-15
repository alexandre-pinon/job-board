<?php
     $url= "http://localhost/apino-keisay/admin/includes/advertisements.php?id=" . $_POST['id'];

     $data = array(
         "title" => $_POST['title'],
         "description" => $_POST['description'],
         "contract_type" => $_POST['contract_type'],
         "starting_date" => $_POST['starting_date'],
         "min_salary" => $_POST['min_salary'],
         "max_salary" => $_POST['max_salary'],
         "localisation" => $_POST['localisation'],
         "study_level" => $_POST['study_level'],
         "experience_years" => $_POST['experience_years'],
         "company_id" => $_POST['company_id']
     );
    
     $ch = curl_init($url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
     curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
    
     $response = curl_exec($ch);
    
     if (!$response) 
     {
         return false;
     }
     else
     {
        echo "Update Successfully";
     }

    #$requestMethod = $_SERVER["REQUEST_METHOD"];
    #echo $requestMethod;
    #echo $_POST['id'];
?>