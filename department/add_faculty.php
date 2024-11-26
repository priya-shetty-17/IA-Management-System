<?php
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle the form submission
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $department = $_POST['department'];
    $role = $_POST['role'];
    
    // Handle file upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        // Get the image content as binary data
        $imageData = file_get_contents($_FILES['profile_picture']['tmp_name']);
        
        // Insert faculty data into the database
        $sql = "INSERT INTO faculty (fname, femail, fphone, deptid, frole, fprofile) 
                VALUES (:fname, :femail, :fphone, :deptid, :frole, :fprofile)";
        
        $stmt = $pdo->prepare($sql);
        
        // Bind values to the SQL statement
        $stmt->bindParam(':fname', $name);
        $stmt->bindParam(':femail', $email);
        $stmt->bindParam(':fphone', $phone);
        $stmt->bindParam(':deptid', $department);
        $stmt->bindParam(':frole', $role);
        $stmt->bindParam(':fprofile', $imageData, PDO::PARAM_LOB); // Store the image as a BLOB
        
        // Execute the query and insert data
        if ($stmt->execute()) {
            // Redirect back to the faculty management page or show a success message
            header("Location: dpt_faculty.php");
            exit();
        } else {
            die("Error inserting faculty data.");
        }
    } else {
        die("Error uploading file.");
    }
} else {
    die("Invalid request.");
}
?>
