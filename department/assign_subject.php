<?php
// Include configuration and session files
include '../config.php';
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch the logged-in user's department for session use
$email = $_SESSION['email'];
$stmt = $pdo->prepare("SELECT deptid, dname FROM department WHERE demail = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();
$user = $stmt->fetch();

if ($user) {
    $_SESSION['deptid'] = $user['deptid'];
}

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;

    if ($action === 'getSubjects') {
        $semester = $_POST['semester'] ?? '';
        $deptid = $_SESSION['deptid'];
    
        // Fetch subjects for the selected semester
        $stmt = $pdo->prepare("SELECT subid, name, code, facid FROM subject WHERE semester = :semester AND deptid = :deptid");
        $stmt->execute(['semester' => $semester, 'deptid' => $deptid]);
        $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Add an 'assigned' flag for subjects with an assigned faculty
        foreach ($subjects as &$subject) {
            $subject['assigned'] = !empty($subject['facid']);
        }
        echo json_encode($subjects);
        exit;
    }

    if ($action === 'getDepartments') {
        // Fetch all departments
        $stmt = $pdo->query("SELECT deptid, dname FROM department");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        exit;
    }

    if ($action === 'getFaculties') {
        $deptid = $_POST['deptid'] ?? null;
    
        if (!$deptid) {
            echo json_encode(['error' => 'No department ID provided']);
            exit();
        }
    
        $stmt = $pdo->prepare("SELECT facid, fname FROM faculty WHERE deptid = ?");
        $stmt->execute([$deptid]);
        $faculties = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        echo json_encode($faculties ?: ['error' => 'No faculties found for this department']);
        exit();
    }

    if ($_POST['action'] === 'getFacultyDetails') {
        $facid = $_POST['facid'];
        $sql = "SELECT * FROM faculty WHERE facid = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$facid]);
        $faculty = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($faculty);
    }

    if ($action === 'assignFaculty') {
        $subid = $_POST['subid'] ?? null;
        $facid = $_POST['facid'] ?? null;
    
        if ($subid && $facid) {
            // Update the faculty assignment
            $stmt = $pdo->prepare("UPDATE subject SET facid = :facid WHERE subid = :subid");
            $success = $stmt->execute(['facid' => $facid, 'subid' => $subid]);
    
            echo json_encode(['success' => $success]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid subject or faculty.']);
        }
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Subject</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/assign_sub.css">
</head>
<body>
    <!-- Back Arrow Button -->
    <a href="index.php" class="btn btn-link position-absolute" style="top: 20px; left: 20px; z-index: 9999;">
        <i class="bi bi-arrow-left-circle-fill" style="font-size: 30px;"></i>
    </a>

    <!-- Page Content -->
    <div class="container mt-5">
        <h2 class="text-primary mb-4">Assign Subject</h2>
        <div class="mb-3">
            <label for="semester" class="form-label">Select Semester</label>
            <select id="semester" class="form-select">
                <option value="">Select Semester</option>
                <?php foreach (range(1, 8) as $sem): ?>
                    <option value="<?= htmlspecialchars($sem) ?>"><?= htmlspecialchars($sem) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div id="subjectsContainer" class="mt-4"></div>
    </div>

    <script src="js/assign_sub.js"></script>
</body>
</html>
