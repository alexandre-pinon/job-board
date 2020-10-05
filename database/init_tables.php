<?php
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "jobboard";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// sql to create table
$sql = "CREATE TABLE IF NOT EXISTS company (
    id INT(6) UNSIGNED AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    logo VARCHAR(100),
    background VARCHAR(100),

    PRIMARY KEY (id)
)";
    
if ($conn->query($sql) === TRUE) {
    echo "Table company created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

// sql to create table
$sql = "CREATE TABLE IF NOT EXISTS advertisement (
    id INT(6) UNSIGNED AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    description VARCHAR(5000) NOT NULL,
    contract_type VARCHAR(30) NOT NULL,
    starting_date DATE,
    min_salary INT(6),
    max_salary INT(6),
    localisation VARCHAR(100) NOT NULL,
    study_level VARCHAR(100),
    experience_years INT(2),
    company_id INT(6) NOT NULL,

    PRIMARY KEY (id),
    FOREIGN KEY (company_id) REFERENCES company(id)
)";

if ($conn->query($sql) === TRUE) {
  echo "<br>Table advertisement created successfully";
} else {
  echo "<br>Error creating table: " . $conn->error;
}

// sql to create table
$sql = "CREATE TABLE IF NOT EXISTS user (
    id INT(6) UNSIGNED AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    password VARCHAR(100) NOT NULL,
    profile VARCHAR(20) NOT NULL, -- admin or candidate
    cv VARCHAR(200), -- Nom du fichier CV

    PRIMARY KEY (id),
    UNIQUE (email),
    UNIQUE (name)
)";
    
if ($conn->query($sql) === TRUE) {
    echo "<br>Table user created successfully";
} else {
    echo "<br>Error creating table: " . $conn->error;
}

// init admin
$sql = "INSERT INTO user (name, email, password, profile)
SELECT 
    'apino',
    'alexandre.pinon@epitech.eu',
    'password',
    'admin'
WHERE NOT EXISTS ( 
    SELECT 1 
    FROM user
    WHERE email = 'alexandre.pinon@epitech.eu'
)";

if ($conn->query($sql) === TRUE) {
    echo "<br>Admin created successfully";
} else {
    echo "<br>Error creating admin: " . $conn->error;
}

// sql to create table
$sql = "CREATE TABLE IF NOT EXISTS job_application (
    id INT(6) UNSIGNED AUTO_INCREMENT,
    user_id INT(6),
    advertisement_id INT(6) NOT NULL,
    name VARCHAR(100),
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    cv VARCHAR(200), -- Nom du fichier CV
    message VARCHAR(1000) NOT NULL,

    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES user(id),
    FOREIGN KEY (advertisement_id) REFERENCES advertisement(id)
)";
    
if ($conn->query($sql) === TRUE) {
    echo "<br>Table user created successfully";
} else {
    echo "<br>Error creating table: " . $conn->error;
}

$conn->close();
?>