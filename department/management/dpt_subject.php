<?php
// Start session and check if user is logged in
session_start();

if (!isset($_SESSION['deptid'])) {
    header("Location: department/departmentlogin.php");
    exit();
}

// Database configuration
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'inernal_assessment';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle form submission to add a subject
if (isset($_POST['add_subject'])) {
    $subid = $_POST['subid'];
    $semester = $_POST['semester'];
    $subject_name = $_POST['subject_name'];
    $subject_code = $_POST['subject_code'];
    $credits = $_POST['credits'];

    // Validation to check if any field is empty
    if (!empty($subid) && !empty($semester) && !empty($subject_name) && !empty($subject_code) && !empty($credits)) {
        $stmt = $pdo->prepare("INSERT INTO subject (subid, semester, name, code, credit) VALUES (:subid, :semester, :subject_name, :subject_code, :credits)");
        $stmt->execute([
            ':subid' => $subid,
            ':semester' => $semester,
            ':subject_name' => $subject_name,
            ':subject_code' => $subject_code,
            ':credits' => $credits,
        ]);

        echo "<script>alert('Subject added successfully.');</script>";

        // Reload page after submission to clear form
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Please fill out all fields.');</script>";
    }
}

// Handle subject deletion
if (isset($_POST['delete_subject'])) {
    $subject_id = $_POST['subject_id'];

    if (!empty($subject_id)) {
        $stmt = $pdo->prepare("DELETE FROM subject WHERE subid = :subid");
        $stmt->execute([':subid' => $subject_id]);

        echo "<script>alert('Subject deleted successfully.');</script>";

        // Redirect to avoid form resubmission
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject Management</title>
    <link rel="stylesheet" href="style.css"> <!-- Linking the external CSS -->
</head>
<body>
    <h1>MCA Department - Subject Management</h1>

    <form action="" method="POST">
        <label for="sub_id">Subject ID:</label>
        <input type="text" id="sub_id" name="subid" required><br>

        <label for="semester">Semester:</label>
        <input type="text" id="semester" name="semester" required><br>

        <label for="subject_name">Subject Name:</label>
        <input type="text" id="subject_name" name="subject_name" required><br>

        <label for="subject_code">Subject Code:</label>
        <input type="text" id="subject_code" name="subject_code" required><br>

        <label for="credits">Credits:</label>
        <input type="number" id="credits" name="credits" min="1" max="10" required><br>

        <button type="submit" name="add_subject">Add Subject</button>
    </form>

    <h2>Subjects List</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Subject ID</th>
                <th>Semester</th>
                <th>Subject Name</th>
                <th>Subject Code</th>
                <th>Credits</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $pdo->query("SELECT subid, semester, name AS subject_name, code AS subject_code, credit AS credits FROM subject ORDER BY semester, code");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>{$row['subid']}</td>
                        <td>{$row['semester']}</td>
                        <td>{$row['subject_name']}</td>
                        <td>{$row['subject_code']}</td>
                        <td>{$row['credits']}</td>
                        <td>
                            <form action='' method='POST'>
                                <input type='hidden' name='subject_id' value='{$row['subid']}'>
                                <button type='submit' name='delete_subject' onclick='return confirm(\"Are you sure you want to delete this subject?\")'>Delete</button>
                            </form>
                        </td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
