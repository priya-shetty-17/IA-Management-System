<?php
include '../config.php';

// Fetch department data
$deptSql = "SELECT deptid, dname FROM department";
$deptStmt = $pdo->query($deptSql);
$departments = $deptStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch faculty data with department name
$sql = "SELECT f.facid, f.fprofile, f.fname,f.femail,f.fdob, d.dname AS department, f.frole 
        FROM faculty f
        JOIN department d ON f.deptid = d.deptid";
$stmt = $pdo->query($sql);
$facultyData = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/fac.css">
</head>

<body>

    <!-- Dashboard Content -->
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center p-3 mb-4 border-bottom border-primary">
            <h4 class="mb-0 text-primary fw-bold">
                <i class="bi bi-people-fill me-2"></i> Faculty Management
            </h4>
        </div>

        <!-- Faculty Table -->
        <div class="table-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Profile</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>DOB</th>
                        <th>Department</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($facultyData && count($facultyData) > 0) : ?>
                        <?php foreach ($facultyData as $row) : ?>
                            <tr>
                                <td>
                                    <img src="data:image/jpeg;base64,<?= base64_encode($row['fprofile']); ?>" alt="Profile" class="profile-img">
                                </td>
                                <td><?= htmlspecialchars($row['fname']); ?></td>
                                <td><?= htmlspecialchars($row['femail']); ?></td>
                                <td><?= htmlspecialchars($row['fdob']); ?></td>
                                <td><?= htmlspecialchars($row['department']); ?></td>
                                <td><?= htmlspecialchars($row['frole']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" class="text-center">No faculty found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
