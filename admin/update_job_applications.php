<?php
     $url= "http://localhost/apino-keisay/admin/includes/job_applications.php?id=" . $_POST['id'];

     $data = array(
         "user_id" => $_POST['user_id'],
         "advertisement_id" => $_POST['advertisement_id'],
         "name" => $_POST['name'],
         "email" => $_POST['email'],
         "phone" => $_POST['phone'],
         "cv" => $_POST['cv'],
         "message" => $_POST['message']
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

    #$requestMethod = $_SERVER["REQUEST_METHOD"];
    #echo $requestMethod;
    #echo $_POST['id'];
?>