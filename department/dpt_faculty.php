<?php
include '../config.php';

// Fetch department data
$deptSql = "SELECT deptid, dname FROM department";
$deptStmt = $pdo->query($deptSql);
$departments = $deptStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch faculty data with department name
$sql = "SELECT f.facid, f.fprofile, f.fname, d.dname AS department, f.frole 
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
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
        }

        .profile-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .table-container {
            margin-top: 20px;
        }

        .modal-content {
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.25), 0 0 20px rgba(0, 123, 255, 0.5);
            overflow: hidden;
        }

        .modal-header {
            background-color: #007bff;
            color: white;
            font-size: 1.2rem;
        }

        .modal-body {
            padding: 20px;
        }

        .form-label {
            font-weight: 600;
        }

        .form-control {
            border-radius: 5px;
            box-shadow: none;
        }

        .btn-custom {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }

        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }

        .table thead {
            background-color: #007bff;
            color: white;
        }

        .table-container table {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .add-faculty-btn {
            margin-top: 10px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .modal-dialog {
                max-width: 100%;
                margin: 15px;
            }

            .modal-body {
                padding: 15px;
            }

            .form-label {
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
    <?php
        include '../include/header.php';
    ?>

    <!-- Dashboard Content -->
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center">
            <h4>Faculty Management</h4>
            <button id="addFacultyToggle" class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#addFacultyModal">Add Faculty</button>
        </div>

        <!-- Faculty Table -->
        <div class="table-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Faculty ID</th>
                        <th>Profile</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($facultyData && count($facultyData) > 0) : ?>
                        <?php foreach ($facultyData as $row) : ?>
                            <tr>
                                <td><?= htmlspecialchars($row['facid']); ?></td>
                                <td>
                                    <!-- Display the image from BLOB field -->
                                    <img src="data:image/jpeg;base64,<?= base64_encode($row['fprofile']); ?>" alt="Profile" class="profile-img">
                                </td>
                                <td><?= htmlspecialchars($row['fname']); ?></td>
                                <td><?= htmlspecialchars($row['department']); ?></td>
                                <td><?= htmlspecialchars($row['frole']); ?></td>
                                <td>
                                    <a href="view_faculty.php?facid=<?= $row['facid']; ?>" class="btn btn-info btn-sm">View</a>
                                    <a href="edit_faculty.php?facid=<?= $row['facid']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="delete_faculty.php?facid=<?= $row['facid']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this faculty?')">Delete</a>
                                </td>
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

    <!-- Bootstrap Modal for Add Faculty -->
<div class="modal fade" id="addFacultyModal" tabindex="-1" aria-labelledby="addFacultyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addFacultyModalLabel">Add Faculty</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="add_faculty.php" method="POST" enctype="multipart/form-data" class="row g-3">
                    <!-- Faculty Name -->
                    <div class="col-md-6">
                        <label for="name" class="form-label">Faculty Name</label>
                        <input type="text" id="name" name="name" class="form-control" required 
                               pattern="[A-Za-z\s]+" title="Name can only contain letters and spaces">
                    </div>
                    <!-- Email -->
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" required 
                               pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" title="Enter a valid email address">
                    </div>
                    <!-- Phone -->
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" id="phone" name="phone" class="form-control" required 
                               pattern="^\d{10}$" title="Phone number must be exactly 10 digits">
                    </div>
                    <!-- Department -->
                    <div class="col-md-6">
                        <label for="department" class="form-label">Department</label>
                        <select id="department" name="department" class="form-select" required>
                            <option value="" disabled selected>Select Department</option>
                            <?php foreach ($departments as $dept) : ?>
                                <option value="<?= $dept['deptid']; ?>"><?= htmlspecialchars($dept['dname']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- Role -->
                    <div class="col-md-6">
                        <label for="role" class="form-label">Role</label>
                        <select id="role" name="role" class="form-select" required>
                            <option value="" disabled selected>Select Role</option>
                            <option value="Professor">Professor</option>
                            <option value="Assistant Professor">Assistant Professor</option>
                            <option value="Lecturer">Lecturer</option>
                        </select>
                    </div>
                    <!-- Profile Picture -->
                    <div class="col-md-6">
                        <label for="profile_picture" class="form-label">Profile Picture</label>
                        <input type="file" id="profile_picture" name="profile_picture" class="form-control" accept="image/*" required>
                    </div>
                    <!-- Submit Button -->
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary w-100">Save Faculty</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
