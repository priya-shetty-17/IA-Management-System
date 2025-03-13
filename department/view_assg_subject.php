<?php
// Include your database configuration and session start
include '../config.php';
session_start();

if (!isset($_SESSION['email'])) {
    error_log('Unauthorized access: session not set for deptid');
    echo json_encode(['error' => 'Unauthorized access']);
    exit;
}

$email = $_SESSION['email'];

try {
    // Fetch the deptid for the logged-in user
    $sql = "SELECT deptid FROM department WHERE demail = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && isset($result['deptid'])) {
        $deptid = $result['deptid'];
    } else {
        error_log('Unauthorized access: no matching department for email');
        echo json_encode(['error' => 'Unauthorized access']);
        exit;
    }
} catch (PDOException $e) {
    error_log('Database error: ' . $e->getMessage());
    echo json_encode(['error' => 'Internal server error']);
    exit;
}


// Handle AJAX Requests
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch semesters dynamically
    if (isset($_GET['action']) && $_GET['action'] === 'getSemesters') {
        try {
            $sql = "SELECT DISTINCT semester FROM subject WHERE deptid = :deptid";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['deptid' => $deptid]);
            $semesters = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($semesters);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Failed to fetch semesters']);
        }
        exit;
    }

   // Fetch subjects based on the selected semester
    if (isset($_GET['action']) && $_GET['action'] === 'getSubjects') {
        $semester = $_GET['semester'];
        if (!empty($semester)) {
            try {
                $sql = "
                    SELECT s.name AS subject_name, s.code AS subject_code, s.credit, 
                        f.fname AS faculty_name, d.dname AS faculty_department,
                        CASE WHEN s.facid IS NULL THEN 1 ELSE 0 END AS is_blocked
                    FROM subject s
                    LEFT JOIN faculty f ON s.facid = f.facid
                    LEFT JOIN department d ON f.deptid = d.deptid
                    WHERE s.deptid = :deptid AND s.semester = :semester";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['deptid' => $deptid, 'semester' => $semester]);
                $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($subjects);
            } catch (PDOException $e) {
                echo json_encode(['error' => 'Failed to fetch subjects']);
            }
        } else {
            echo json_encode(['error' => 'Invalid semester selected']);
        }
        exit;
    }

    // Handle View faculty details
    if (isset($_GET['action']) && $_GET['action'] === 'viewFaculty') {
        $subjectCode = $_GET['subject_code'] ?? '';
        if (!empty($subjectCode)) {
            try {
                $sql = "
                    SELECT f.fname, f.femail, f.fphone, f.fdob, d.dname AS department_name,
                        s.facid AS faculty_id
                    FROM subject s
                    LEFT JOIN faculty f ON s.facid = f.facid
                    LEFT JOIN department d ON f.deptid = d.deptid
                    WHERE s.code = :subject_code AND s.deptid = :deptid";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['subject_code' => $subjectCode, 'deptid' => $deptid]);
                $facultyDetails = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($facultyDetails && !$facultyDetails['faculty_id']) {
                    echo json_encode(['error' => 'Faculty not assigned.']);
                    exit;
                }                

                if ($facultyDetails) {
                    header('Content-Type: application/json');
                    echo json_encode($facultyDetails);
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(['error' => 'Faculty details not found.']);
                }
            } catch (PDOException $e) {
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Failed to fetch faculty details']);
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Invalid subject code or department ID']);
        }
        exit;
    }
}

// Unassign a subject
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'unassign') {
        $subjectCode = $_POST['subject_code'] ?? '';
        if (!empty($subjectCode)) {
            try {
                $sql = "UPDATE subject SET facid = NULL WHERE code = :subject_code AND deptid = :deptid AND facid IS NOT NULL";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['subject_code' => $subjectCode, 'deptid' => $deptid]);
                echo json_encode(['success' => true]);
            } catch (PDOException $e) {
                echo json_encode(['error' => 'Failed to unassign the subject']);
            }
        } else {
            echo json_encode(['error' => 'Invalid subject code']);
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
    <title>Assigned Subjects</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/view_assg_sub.css"> 
</head>
<body>
    <!-- Back Arrow Button -->
    <a href="index.php" class="btn btn-link position-absolute" style="top: 20px; left: 20px; z-index: 9999;">
        <i class="bi bi-arrow-left-circle-fill" style="font-size: 30px;"></i>
    </a>
    <div class="container">
        <h2>Assigned Subjects</h2>
        <div class="mb-3">
            <label for="semesterDropdown" class="form-label">Select Semester</label>
            <select id="semesterDropdown" class="form-select"></select>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Subject Name</th>
                        <th>Code</th>
                        <th>Credits</th>
                        <th>Faculty Name</th>
                        <th>Faculty Department</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="subjectsContainer">
                    <!-- Dynamic Rows Will Be Populated Here -->
                </tbody>
            </table>
        </div>
    </div>
    <script src="js/view_assg_subject.js"></script>
</body>
</html>
