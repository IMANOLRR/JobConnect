<?php
// Database connection script
$host = "localhost";
$user = "root";
$password = "admin";
$dbname = "jobconnect_db";

$conn = new mysqli($host, $user, $password, $dbname);

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}else{
    echo "Connected successfully";
}
