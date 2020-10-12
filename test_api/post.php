<?php
	$url = 'http://job-board/api/users.php';
	$data = array(
		'name' => 'THE JOB APP',
		'email' => 'eiojfoz@ger.erg',
		'phone' => '0123456789',
		'password' => '123456',
		'cv' => ''
    );

	// use key 'http' even if you send the request to https://...
	$options = array(
		'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => http_build_query($data)
		)
	);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	if ($result === FALSE) { /* Handle error */ }

	echo var_dump($result);
?>