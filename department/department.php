<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Home Page</title>
    <link rel="stylesheet" href="../department/css/home.css">
    <script src="../department/js/home.js" defer></script>
</head>
<body>

    <!-- PHP Code to Start Session and Check Login -->
    <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        

        // Check if the user is logged in
        if (!isset($_SESSION['deptid'])) {
            // Redirect to the login page if the session is not set
            header("Location: department/departmentlogin.php");
            exit();
        }

        // Debugging: Check session data (optional, remove after testing)
        // var_dump($_SESSION);

        // Include header (Navigation Bar)
        include '../department/include/header.php';
    ?>

            <!-- Main Content Section -->
    <div class="main-content">
        <section class="dashboard">
            <div class="card student-card">
                <h3>Students</h3>
                <p class="count">120</p>
            </div>
            <div class="card faculty-card">
                <h3>Faculty</h3>
                <p class="count">15</p>
            </div>
            <div class="card staff-card">
                <h3>Staff</h3>
                <p class="count">8</p>
            </div>
        </section>
    </div>
</body>
</html>
