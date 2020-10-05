<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS jobBoard";
if ($conn->query($sql) === TRUE) {
  echo "Database created successfully";
} else {
  echo "Error creating database: " . $conn->error;
}

// Create user
$sql = "CREATE USER IF NOT EXISTS 'admin'@'localhost' IDENTIFIED BY 'admin'";
if ($conn->query($sql) === TRUE) {
  echo "<br>User created successfully";
} else {
  echo "<br>Error creating user: " . $conn->error;
}

// Grant Privileges
$sql = "GRANT ALL PRIVILEGES ON * . * TO 'admin'@'localhost'";
if ($conn->query($sql) === TRUE) {
  echo "<br>Privileges granted successfully";
} else {
  echo "<br>Error granting privileges: " . $conn->error;
}

$conn->close();
?>