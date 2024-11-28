<?php
session_start();

if (!isset($_SESSION['deptid'])) {
    header("Location: ../department/dpt_student.php");
    exit();
}

include '../include/header.php';

require_once __DIR__ . '/../../vendor/autoload.php'; // Include PhpSpreadsheet library

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

// Database configuration
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'internal_assessment';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Check if file is uploaded
if (isset($_POST['upload'])) {
    $file = $_FILES['excel_file']['tmp_name'];

    if (!file_exists($file)) {
        echo "<script>alert('Please upload an Excel file.');</script>";
    } else {
        try {
            $spreadsheet = IOFactory::load($file);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            foreach ($rows as $key => $row) {
                if ($key == 0) continue; // Skip header row

                [$sid, $usn, $sname, $dob, $email, $phone, $deptid, $year_of_study] = $row;

                // Insert data into database
                $stmt = $pdo->prepare("INSERT INTO student (sid, usn, sname, dob, email, phone, deptid, year_of_study) 
                                       VALUES (:sid, :usn, :sname, :dob, :email, :phone, :deptid, :year_of_study)");
                $stmt->execute([
                    ':sid' => $sid,
                    ':usn' => $usn,
                    ':sname' => $sname,
                    ':dob' => $dob,
                    ':email' => $email,
                    ':phone' => $phone,
                    ':deptid' => $deptid,
                    ':year_of_study' => $year_of_study
                ]);
            }

            echo "<script>alert('Students added successfully from Excel.');</script>";
        } catch (Exception $e) {
            echo "<script>alert('Error processing Excel file: " . $e->getMessage() . "');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Students</title>
</head>
<body>
    <h1>Import Students from Excel</h1>
    <!-- Form to upload the Excel file -->
    <form action="import_students.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="excel_file" accept=".xlsx, .xls" required>
        <button type="submit" name="upload">Upload and Import</button>
    </form>
</body>
</html>
