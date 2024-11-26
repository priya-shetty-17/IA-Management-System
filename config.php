<?php
// Database configuration
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'internal_assessment';

try {
    // PDO Connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // MySQLi Connection (for backward compatibility)
    $conn = new mysqli($host, $user, $password, $dbname);

    // Check for MySQLi connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
