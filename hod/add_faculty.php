<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Admin Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

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
        <!-- Sidebar Start -->
        <?php include 'sidebar.php'; ?>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <?php include 'navbar.php'; ?>
            <!-- Navbar End -->

            <!-- Faculty Details Form -->
            <div class="container mt-5">
                <h2 class="form-title text-center">Faculty Details Form</h2>
                <form action="" method="POST" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="fname" class="form-label">Name:</label>
                        <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter your full name" required>
                    </div>

                    <div class="form-group">
                        <label for="femail" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="femail" name="femail" placeholder="Enter your email address" required>
                    </div>

                    <div class="form-group">
                        <label for="department" class="form-label">Department</label>
                        <select id="department" name="department" class="form-select" required>
                            <option value="" disabled selected>Select Department</option>
                            <?php foreach ($departments as $dept) : ?>
                                <option value="<?= htmlspecialchars($dept['deptid']); ?>"><?= htmlspecialchars($dept['dname']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="role" class="form-label">Role</label>
                        <select id="role" name="role" class="form-select" required>
                            <option value="" disabled selected>Select Role</option>
                            <option value="Professor">Professor</option>
                            <option value="Assistant Professor">Assistant Professor</option>
                            <option value="Lecturer">Lecturer</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="fphone" class="form-label">Phone Number:</label>
                        <input type="tel" class="form-control" id="fphone" name="fphone" placeholder="Enter your phone number" required pattern="[0-9]{10}">
                        <small class="form-text text-muted">Format: 10-digit phone number without dashes or spaces.</small>
                    </div>

                    <div class="form-group">
                        <label for="fdob" class="form-label">Date of Birth:</label>
                        <input type="date" class="form-control" id="fdob" name="fdob" required>
                    </div>

                    <div class="form-group">
                        <label for="profile_picture" class="form-label">Profile Picture</label>
                        <input type="file" id="profile_picture" name="profile_picture" class="form-control" accept="image/*" required>
                    </div>

                    <div class="form-group">
                        <label for="fpassword" class="form-label">Password:</label>
                        <input type="password" class="form-control" id="fpassword" name="fpassword" placeholder="Enter your password" required>
                        <small class="form-text text-muted">Your password must be at least 8 characters long.</small>
                    </div>

                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                </form>
            </div>
            <!-- Faculty Details Form End -->
        </div>
        <!-- Content End -->
    </div>

    <!-- PHP Code to Handle Submission -->
    <?php
    include '../config.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            $name = htmlspecialchars($_POST['fname']);
            $email = htmlspecialchars($_POST['femail']);
            $phone = htmlspecialchars($_POST['fphone']);
            $dob = htmlspecialchars($_POST['fdob']);
            $department = htmlspecialchars($_POST['department']);
            $role = htmlspecialchars($_POST['role']);
            $password = password_hash($_POST['fpassword'], PASSWORD_BCRYPT);

            if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
                $imageData = file_get_contents($_FILES['profile_picture']['tmp_name']);

                $sql = "INSERT INTO faculty (fname, femail, fphone, deptid, frole, fprofile) 
                        VALUES (:fname, :femail, :fphone, :deptid, :frole, :fprofile)";

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':fname', $name);
                $stmt->bindParam(':femail', $email);
                $stmt->bindParam(':fphone', $phone);
                $stmt->bindParam(':fdob', $dob);
                $stmt->bindParam(':deptid', $department);
                $stmt->bindParam(':frole', $role);
                $stmt->bindParam(':fprofile', $imageData, PDO::PARAM_LOB);

                if ($stmt->execute()) {
                    header("Location: add_faculty.php");
                    exit();
                } else {
                    echo "Error inserting faculty data.";
                }
            } else {
                echo "Error uploading file.";
            }
        } catch (Exception $e) {
            echo "An error occurred: " . $e->getMessage();
        }
    }
    ?>

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
    <script src="js/main.js"></script>
</body>

</html>
