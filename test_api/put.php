<?php
    $url = 'http://job-board/api/users/7'; // modifier le produit 12
    $data = array(
        'name' => 'bwaaaaaaa',
        'email' => 'eiojfoz@ger.erg',
        'phone' => '0123456789',
        'password' => '123456',
        'profile' => 'applicant',
        'cv' => ''
    );

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));

    $response = curl_exec($ch);

    var_dump($response);

    if (!$response) 
    {
        return false;
    }
?>