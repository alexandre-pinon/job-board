<?php
     $url= "http://localhost/apino-keisay/admin/includes/companies.php?id=" . $_POST['id'];

     $data = array(
         "name" => $_POST['name'],
         "logo" => $_POST['logo'],
         "background" => $_POST['background']
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