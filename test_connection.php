<?php
include('../config.php');

try {
    $stmt = $pdo->query("SHOW TABLES");
    if ($stmt) {
        echo "Database connection successful! Here are the tables:<br>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo $row['Tables_in_internal_assessment'] . "<br>";
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
