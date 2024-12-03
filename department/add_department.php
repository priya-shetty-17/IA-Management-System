<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title> Add Department</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/SJECLogo.png" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/Styles.css" rel="stylesheet">
</head>

    <body>
        <div class="container-xxl position-relative bg-white d-flex p-0">
            <!-- Spinner Start -->
            <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
                <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <!-- Spinner End -->


            <!-- Sidebar Start -->
        <?php include 'sidebar.php';?>
            <!-- Sidebar End -->


            <!-- Content Start -->
            <div class="content">
                <!-- Navbar Start -->
               <?php include 'navbar.php';?>
            <!-- Navbar End -->


            <!-- Other Elements Start -->
                <div class="container mt-5">
                    <h2 class="form-title text-center">Department Details Form</h2>
                    <p class="form-description text-center text-muted">Please fill out the form below to submit your department details.</p>
                    <form action="add_department.php" method="POST" enctype="multipart/form-data" class="department-form">
                        <!-- Department Name -->
                        <div class="form-group">
                            <label for="dname" class="form-label">Department Name:</label>
                            <input type="text" class="form-control" id="dname" name="dname" placeholder="Enter department name" required>
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter department email address" required>
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label for="dpassword" class="form-label">Password:</label>
                            <input type="password" class="form-control" id="dpassword" name="dpassword" placeholder="Create a secure password" required>
                            <small class="form-text text-muted">Your password should be at least 8 characters long.</small>
                        </div>
                            <button  type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>


            <!-- Other Elements End -->
            <!-- Footer Start -->
            <!-- Footer End -->
            </div>
            <!-- Content End -->


            <!-- Back to Top -->
            <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
        </div>

        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="lib/chart/chart.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/waypoints/waypoints.min.js"></script>
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="lib/tempusdominus/js/moment.min.js"></script>
        <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
        <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

        <!-- Template Javascript -->
        <script src="js/main.js"></script>
    </body>

</html>

<?php
// Include the database connection file
require '../config.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data and sanitize
    $dname = htmlspecialchars($_POST['dname'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $dpassword = htmlspecialchars($_POST['dpassword'], ENT_QUOTES, 'UTF-8');

    // SQL query to insert data
    $sql = "INSERT INTO department (dname, email, dpassword) VALUES (:dname, :email, :dpassword)";

    try {
        // Prepare and execute the query
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':dname' => $dname,
            ':email' => $email,
            ':dpassword' => $dpassword
        ]);

        // Success message
        echo "New department added successfully.";
    } catch (PDOException $e) {
        // Handle any errors
        echo "Error: " . $e->getMessage();
    }
}
?>

