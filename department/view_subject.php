<?php
// Include configuration and session files
include '../config.php';
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch department ID based on session email
$stmt = $pdo->prepare("SELECT deptid FROM department WHERE demail = :email");
$stmt->bindParam(':email', $_SESSION['email'], PDO::PARAM_STR);
$stmt->execute();
$department = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$department) {
    die("Department not found!");
}

$deptid = $department['deptid'];

// Fetch subjects for the logged-in department
$stmt = $pdo->prepare("SELECT * FROM subject WHERE deptid = :deptid");
$stmt->bindParam(':deptid', $deptid, PDO::PARAM_INT);
$stmt->execute();
$subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle edit request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_subject'])) {
    $subid = $_POST['subid'];
    $name = $_POST['name'];
    $code = $_POST['code'];
    $semester = $_POST['semester'];
    $credit = $_POST['credit'];
    $total_hour = $_POST['total_hour'];

    $stmt = $pdo->prepare("UPDATE subject SET name = :name, code = :code, semester = :semester, credit = :credit, total_hour = :total_hour WHERE subid = :subid");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':code', $code);
    $stmt->bindParam(':semester', $semester);
    $stmt->bindParam(':credit', $credit);
    $stmt->bindParam(':total_hour', $total_hour);
    $stmt->bindParam(':subid', $subid, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $success = "Subject updated successfully!";
    } else {
        $error = "Failed to update the subject. Please try again.";
    }
}

// Handle delete request
if (isset($_GET['delete'])) {
    $subid = $_GET['delete'];

    $stmt = $pdo->prepare("DELETE FROM subject WHERE subid = :subid");
    $stmt->bindParam(':subid', $subid, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $success = "Subject deleted successfully!";
    } else {
        $error = "Failed to delete the subject.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Subjects</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/view_sub.css"> <!-- Add your custom styles here -->
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-primary">View Subjects</h2>
        <?php if (isset($success)): ?>
            <div class="message-popup success"><?= htmlspecialchars($success) ?></div>
        <?php elseif (isset($error)): ?>
            <div class="message-popup error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <table class="table table-striped table-hover mt-4">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Subject Name</th>
                    <th>Code</th>
                    <th>Semester</th>
                    <th>Credits</th>
                    <th>Total Hours</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($subjects): ?>
                    <?php foreach ($subjects as $index => $subject): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($subject['name']) ?></td>
                            <td><?= htmlspecialchars($subject['code']) ?></td>
                            <td><?= htmlspecialchars($subject['semester']) ?></td>
                            <td><?= htmlspecialchars($subject['credit']) ?></td>
                            <td><?= htmlspecialchars($subject['total_hour']) ?></td>
                            <td>
                                <button 
                                    class="btn btn-warning btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editModal" 
                                    data-subid="<?= $subject['subid'] ?>" 
                                    data-name="<?= htmlspecialchars($subject['name']) ?>" 
                                    data-code="<?= htmlspecialchars($subject['code']) ?>" 
                                    data-semester="<?= htmlspecialchars($subject['semester']) ?>" 
                                    data-credit="<?= htmlspecialchars($subject['credit']) ?>" 
                                    data-total_hour="<?= htmlspecialchars($subject['total_hour']) ?>">
                                    Edit
                                </button>
                                <a href="?delete=<?= $subject['subid'] ?>" 
                                   onclick="return confirm('Are you sure you want to delete this subject?')" 
                                   class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">No subjects found for your department.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Subject</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="subid" id="edit-subid">
                        <div class="mb-3">
                            <label for="edit-name" class="form-label">Subject Name</label>
                            <input type="text" name="name" id="edit-name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-code" class="form-label">Subject Code</label>
                            <input type="text" name="code" id="edit-code" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-semester" class="form-label">Semester</label>
                            <select name="semester" id="edit-semester" class="form-control" required>
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
                            <label for="edit-credit" class="form-label">Total Credits</label>
                            <input type="number" name="credit" id="edit-credit" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-total_hour" class="form-label">Total Hours</label>
                            <input type="number" name="total_hour" id="edit-total_hour" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="edit_subject" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="js/view_sub.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
