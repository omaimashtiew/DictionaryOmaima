<?php
$host = 'db';  // Use 'db' instead of 'localhost' because that's the service name in docker-compose
$dbname = 'dictionary';
$username = 'root'; 
$password = 'nadeen';   
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

