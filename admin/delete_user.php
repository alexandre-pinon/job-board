<?php
    $url= "http://localhost/apino-keisay/admin/includes/users.php?id=" . $_GET['id'];
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    #curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $result = curl_exec($ch);
    
    curl_close($ch);

    return $result;
?>