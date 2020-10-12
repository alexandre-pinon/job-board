<?php
	$server = "localhost";
	$username = "admin";
	$password = "admin";
	$db = "jobboard";
    $conn = mysqli_connect($server, $username, $password, $db);
    mysqli_set_charset($conn,"utf8");
?>