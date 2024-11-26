<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// // Check if the user is logged in
 if (!isset($_SESSION['email'])) {
     header("Location: ../login.php");
   exit();
 }

 // Include the header
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Home Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../department/css/home.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php  include '../include/header.php'; ?>
    <!-- Main Content -->
    <div class="main-content">
        <main class="p-4">
            <div class="container">
                <h3>Welcome to the Department Dashboard</h3>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Students</h5>
                                <p class="card-text">120</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Faculty</h5>
                                <p class="card-text">15</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Staff</h5>
                                <p class="card-text">8</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="../department/js/home.js"></script>
</body>
</html>
