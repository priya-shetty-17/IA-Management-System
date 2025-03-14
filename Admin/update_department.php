<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$conn = new mysqli('localhost', 'root', '', 'internal_assessment');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if 'deptid' is passed
if (!isset($_GET['deptid'])) {
    die("Invalid Request. Department ID is missing.");
}

$deptid = $_GET['deptid'];

// Fetch existing department details
$sql = "SELECT * FROM department WHERE deptid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $deptid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Department not found.");
}

$department = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dname = $_POST['dname'];
    $demail = $_POST['demail'];
    $dpassword = $_POST['dpassword'];

    $update_sql = "UPDATE department SET dname = ?, demail = ?, dpassword = ? WHERE deptid = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssss", $dname, $demail, $dpassword, $deptid);

    if ($update_stmt->execute()) {
        echo "<script>alert('Department updated successfully!'); window.location.href = 'update_department.php';</script>";
    } else {
        echo "<script>alert('Failed to update department. Please try again.');</script>";
    }
}

$conn->close();
?>

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
                    <h2 class="form-title text-center">Edit Department</h2>
                    
                    <form action="" method="POST" enctype="multipart/form-data" >
                        <!-- Department Name -->
                        <div class="mb-3">
                            <label for="dname" class="form-label">Department Name</label>
                            <input type="text" class="form-control" id="dname" name="dname" value="<?php echo htmlspecialchars($department['dname']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="demail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="demail" name="demail" value="<?php echo htmlspecialchars($department['demail']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="dpassword" class="form-label">Password</label>
                            <input type="text" class="form-control" id="dpassword" name="dpassword" value="<?php echo htmlspecialchars($department['dpassword']); ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="view_department.php" class="btn btn-secondary">Cancel</a>
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