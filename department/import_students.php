<?php
require '././vendor/autoload.php'; // Load PhpSpreadsheet via Composer

use PhpOffice\PhpSpreadsheet\IOFactory;

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "internal_assessment";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['excel_file'])) {
    $uploadDir = './uploads/';
    $fileName = basename($_FILES['excel_file']['name']);
    $targetFilePath = $uploadDir . $fileName;

    // Ensure the uploads directory exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Upload the file to the server
    if (move_uploaded_file($_FILES['excel_file']['tmp_name'], $targetFilePath)) {
        try {
            // Load the spreadsheet
            $spreadsheet = IOFactory::load($targetFilePath);
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray();

            // Loop through each row
            foreach ($data as $index => $row) {
                if ($index == 0) {
                    // Skip the header row
                    continue;
                }

                // Assign values from columns
                $sid = $row[0];
                $sname = $row[1];
                $email = $row[2];
                $dob = $row[3];
                $usn = $row[4];
                $phone = $row[5];
                $deptid = $row[6];
                $year_of_study = $row[7];

                // Insert data into the database
                $stmt = $conn->prepare("INSERT INTO student (sid, sname, email, dob, usn, phone, deptid, year_of_study) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("issssisi", $sid, $sname, $email, $dob, $usn, $phone, $deptid, $year_of_study);

                if (!$stmt->execute()) {
                    echo "Error inserting row: " . $stmt->error . "<br>";
                }
            }

            echo "Data imported successfully!";
        } catch (Exception $e) {
            echo "Error loading file: " . $e->getMessage();
        }
    } else {
        echo "File upload failed!";
    }
} else {
    echo "No file uploaded.";
}
// Close the connection
$conn->close();
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Excel File</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="excel_file">Select Excel File:</label>
        <input type="file" name="excel_file" id="excel_file" required>
        <button type="submit">Upload and Import</button>
    </form>
</body>
</html>
