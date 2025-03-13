<?php
include '../config.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch the logged-in department ID dynamically based on session email
$loggedInEmail = $_SESSION['email'];
$stmt = $pdo->prepare("SELECT deptid FROM department WHERE demail = :email");
$stmt->execute(['email' => $loggedInEmail]);
$deptRow = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$deptRow) {
    echo "Error: Unable to retrieve department information.";
    exit();
}

$loggedInDeptId = $deptRow['deptid'];

// Fetch faculty data for the logged-in department and those teaching its subjects
$sql = "
    SELECT f.facid, f.fphone, f.fname, f.femail, f.fdob, d.dname AS department, f.frole
    FROM faculty f
    JOIN department d ON f.deptid = d.deptid
    WHERE f.deptid = :loggedInDeptId
    UNION
    SELECT f.facid, f.fphone, f.fname, f.femail, f.fdob, d.dname AS department, f.frole
    FROM faculty f
    JOIN subject s ON f.facid = s.facid
    JOIN department d ON f.deptid = d.deptid
    WHERE s.deptid = :loggedInDeptId";

$stmt = $pdo->prepare($sql);
$stmt->execute(['loggedInDeptId' => $loggedInDeptId]);
$facultyData = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Management</title>
    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>


<body>
    <!-- Back Arrow Button -->
    <a href="index.php" class="btn btn-link position-absolute" style="top: 20px; left: 20px; z-index: 9999;">
        <i class="bi bi-arrow-left-circle-fill" style="font-size: 30px;"></i>
    </a>
            <!-- Faculty Management Section -->
            <div class="container mt-4">
    <!-- Title Section -->
    <div class="d-flex justify-content-between align-items-center p-3 mb-4 border-bottom border-primary bg-light rounded">
        <h4 class="mb-0 text-primary fw-bold">
            <i class="bi bi-people-fill me-2"></i> Faculty Management
        </h4>
    </div>

    <!-- Faculty Table -->
    <div class="table-responsive">
        <table class="table table-striped table-hover shadow-sm">
            <thead class="bg-primary text-white">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>DOB</th>
                    <th>Department</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($facultyData && count($facultyData) > 0) : ?>
                    <?php foreach ($facultyData as $row) : ?>
                        <tr>
                            <td><?= htmlspecialchars($row['fname']); ?></td>
                            <td><?= htmlspecialchars($row['femail']); ?></td>
                            <td><?= htmlspecialchars($row['fphone']); ?></td>
                            <td><?= htmlspecialchars($row['fdob']); ?></td>
                            <td><?= htmlspecialchars($row['department']); ?></td>
                            <td><?= htmlspecialchars($row['frole']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="text-center text-danger">No faculty found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
