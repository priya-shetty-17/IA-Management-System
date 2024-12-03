<?php
// Include configuration and session files
include '../config.php';
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit();
}

// Retrieve the department ID based on the email stored in session
$email = $_SESSION['email'];
$stmt = $pdo->prepare("SELECT deptid FROM department WHERE demail = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();
$user = $stmt->fetch();

// Check if the user was found and retrieve deptid
if ($user) {
    $deptid = $user['deptid'];
} else {
    // If the department is not found, handle the error
    $error = "Department not found for this user.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the form
    $name = $_POST['name'];
    $code = $_POST['code'];
    $semester = $_POST['semester'];
    $credit = $_POST['credit'];
    $total_hour = $_POST['total_hour'];

    // Insert the subject into the database
    $stmt = $pdo->prepare("INSERT INTO subject (name, code, deptid, semester, credit, total_hour) 
                           VALUES (:name, :code, :deptid, :semester, :credit, :total_hour)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':code', $code);
    $stmt->bindParam(':deptid', $deptid);
    $stmt->bindParam(':semester', $semester);
    $stmt->bindParam(':credit', $credit);
    $stmt->bindParam(':total_hour', $total_hour);

    if ($stmt->execute()) {
        $success = "Subject added successfully!";
    } else {
        $error = "Failed to add the subject. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Subject</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/add_sub.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-primary">Add Subject</h2>
        <?php if (isset($success)): ?>
            <div id="successAlert" class="alert alert-success alert-top-right"><?= htmlspecialchars($success) ?></div>
        <?php elseif (isset($error)): ?>
            <div id="errorAlert" class="alert alert-danger alert-top-right"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="name" class="form-label">Subject Name</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="code" class="form-label">Subject Code</label>
                <input type="text" name="code" id="code" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="semester" class="form-label">Semester</label>
                <select name="semester" id="semester" class="form-control" required>
                    <option value="">Select Semester</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="credit" class="form-label">Total Credits</label>
                <input type="number" name="credit" id="credit" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="total_hour" class="form-label">Total Hours</label>
                <input type="number" name="total_hour" id="total_hour" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Subject</button>
        </form>
    </div>
    <script src="js/add_sub.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
