<?php
// Database configuration
$host = "localhost";    // Database host
$username = "root";     // Database username
$password = "";         // Database password
$database = "internal_assessment"; // Replace with your database name

// Connect to the database
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get department ID from request
$deptid = isset($_GET['department_id']) ? intval($_GET['department_id']) : 0;

if ($deptid > 0) {
    // Prepare SQL query to fetch subjects for the given department ID with marks info
    $sql = "
        SELECT 
            s.subid, 
            s.name AS subject_name, 
            s.code, 
            s.semester, 
            s.credit, 
            IFNULL(MAX(marks), 'No Marks') AS marks_updated
        FROM 
            subjects s
        LEFT JOIN 
            marks m ON s.subid = m.subid
        WHERE 
            s.deptid = ?
        GROUP BY 
            s.subid
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $deptid);
    $stmt->execute();
    $result = $stmt->get_result();

    // Initialize an array to hold the subjects
    $subjects = [];

    if ($result->num_rows > 0) {
        // Fetch subjects and store them in the array
        while ($row = $result->fetch_assoc()) {
            $subjects[] = [
                "id" => $row["subid"],
                "name" => $row["subject_name"],
                "code" => $row["code"],
                "semester" => $row["semester"],
                "credit" => $row["credit"],
                "marks_updated" => $row["marks_updated"],
            ];
        }
    }

    // Close the statement
    $stmt->close();

    // Return the subjects as a JSON response
    header("Content-Type: application/json");
    echo json_encode([
        "status" => "success",
        "subjects" => $subjects,
    ]);
} else {
    // Invalid or missing department ID
    echo json_encode([
        "status" => "error",
        "message" => "Invalid department ID",
    ]);
}

// Close the database connection
$conn->close();
?>
 