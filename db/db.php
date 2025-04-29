<?php

$servername = "localhost";  
$username   = "root";       
$password   = "";          
$database   = "august99_books";
// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}