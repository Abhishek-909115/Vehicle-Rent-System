<?php
// Database configuration
$host = 'localhost';
$db_name = 'car_rental';
$username = 'root';
$password = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo"connection successful";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
