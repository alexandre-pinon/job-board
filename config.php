<?php 
// DB credentials.
define('DB_HOST','localhost');
define('DB_USER','admin');
define('DB_PASS','admin');
define('DB_NAME','jobboard');
// Establish database connection.
try
{
$dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS);
}
catch (PDOException $exception)
{
exit("Error: " . $exception->getMessage());
}
?>