<?php
// Start session and check if user is logged in
session_start();

if (!isset($_SESSION['deptid'])) {
    header("Location: ../login.php");
    exit();
}

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

// Add student functionality
if (isset($_POST['add_student'])) {
    $sid = $_POST['sid'];
    $usn = $_POST['usn'];
    $sname = $_POST['name'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $deptid = $_POST['department'];
    $year_of_study = $_POST['year'];
    $enrollment_date = date('Y-m-d');

    // Validate Date of Birth format (YYYY-MM-DD)
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $dob)) {
        echo "<script>alert('Invalid Date of Birth format. Please use YYYY-MM-DD.'); window.location.href = 'add_student.php';</script>";
        exit();
    }

// File upload handling for profile picture
$profile_picture = $_FILES['profile_picture'];
$target_dir = "uploads/";
$profile_filename = null; // Default to null if no file is uploaded

if (!empty($profile_picture['name'])) {
    $profile_filename = time() . "_" . basename($profile_picture['name']);
    $target_file = $target_dir . $profile_filename;

    // Check if the uploaded file is an image
    $check = getimagesize($profile_picture['tmp_name']);
    if ($check === false) {
        echo "<script>alert('File is not an image.');</script>";
        $profile_filename = null; // Reset profile picture if invalid
    } else {
        // Attempt to move the uploaded file to the target directory
        if (!move_uploaded_file($profile_picture['tmp_name'], $target_file)) {
            echo "<script>alert('Failed to upload profile picture.');</script>";
            $profile_filename = null; // Reset profile picture if upload fails
        }
    }
}
$stmt = $pdo->prepare("INSERT INTO student (sid, usn, sname, dob, email, phone, deptid, year_of_study, profile_picture, enrollment_date) 
                       VALUES (:sid, :usn, :sname, :dob, :email, :phone, :deptid, :year_of_study, :profile_picture, :enrollment_date)");
$stmt->execute([
    ':sid' => $sid,
    ':usn' => $usn,
    ':sname' => $sname,
    ':dob' => $dob,
    ':email' => $email,
    ':phone' => $phone,
    ':deptid' => $deptid,
    ':year_of_study' => $year_of_study,
    ':profile_picture' => $profile_filename, // This can be null if no file is uploaded
    ':enrollment_date' => $enrollment_date,
]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link rel="stylesheet" href="/IA-Management-System/department/css/student.css">
</head>
<body>
    <!-- Include header -->
    <?php include '../include/header.php'; ?>

    <div class="container">
        <h1>Add New Student</h1>
        <form action="add_student.php" method="POST" enctype="multipart/form-data" class="student-form">
            <div class="form-group">
                <label for="name">Student Name:</label>
                <input type="text" id="name" name="name" placeholder="Enter student name" required>
            </div>

            <div class="form-group">
                <label for="usn">USN:</label>
                <input type="text" id="usn" name="usn" placeholder="Enter USN" required>
            </div>

            <div class="form-group">
                <label for="dob">Date of Birth (YYYY-MM-DD):</label>
                <input type="date" id="dob" name="dob" required pattern="\d{4}-\d{2}-\d{2}" title="Please enter date in YYYY-MM-DD format.">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter email address" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" placeholder="Enter phone number" required>
            </div>

            <div class="form-group">
                <label for="department">Department:</label>
                <select id="department" name="department" required>
                    <option value="" disabled selected>Select Department</option>
                    <option value="MCA">MCA</option>
                    <option value="CSE">CSE</option>
                    <option value="ECE">ECE</option>
                    <option value="EEE">EEE</option>
                    <option value="ME">ME</option>
                </select>
            </div>

            <div class="form-group">
                <label for="year">Year of Study:</label>
                <select id="year_of_study" name="year_of_study " required>
                    <option value="" disabled selected>Select Year</option>
                    <option value="1">1st Year</option>
                    <option value="2">2nd Year</option>
                    <option value="3">3rd Year</option>
                    <option value="4">4th Year</option>
                </select>
            </div>

            <div class="form-group">
                <label for="profile_picture">Profile Picture:</label>
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*" >
            </div>

            <button type="submit" name="add_student" class="btn-submit">Add Student</button>
        </form>
    </div>
</body>
</html>