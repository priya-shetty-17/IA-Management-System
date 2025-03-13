<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Content-Type: application/json");

// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "internal_assessment";

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]));
}

// Get department ID from request
$deptid = isset($_GET['deptid']) ? intval($_GET['deptid']) : 0;

if ($deptid > 0) {
    // Fetch subjects grouped by semester
    $sql = "SELECT subid, subject_name, code, semester, credit, total_hour FROM subject WHERE deptid = ? ORDER BY semester";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die(json_encode(["status" => "error", "message" => "SQL prepare failed: " . $conn->error]));
    }

    $stmt->bind_param("i", $deptid);
    $stmt->execute();
    $result = $stmt->get_result();

    $subjects = [];
    while ($row = $result->fetch_assoc()) {
        $semester = $row["semester"];
        
        if (!isset($subjects[$semester])) {
            $subjects[$semester] = []; // Create an array for the semester if not exists
        }

        $subjects[$semester][] = [
            "id" => $row["subid"],
            "name" => $row["subject_name"],
            "code" => $row["code"],
            "credit" => $row["credit"],
            "total_hour" => $row["total_hour"]
        ];
    }

    $stmt->close();
    $conn->close();

    echo json_encode(["status" => "success", "subjects" => $subjects]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid department ID"]);
}
?>
