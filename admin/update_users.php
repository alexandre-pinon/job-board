<?php
     $url= "http://localhost/apino-keisay/admin/includes/users.php?id=" . $_POST['id'];

     $data = array(
         "name" => $_POST['name'],
         "email" => $_POST['email'],
         "phone" => $_POST['phone'],
         "password" => $_POST['password'],
         "profile" => $_POST['profile'],
         "cv" => $_POST['cv']
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