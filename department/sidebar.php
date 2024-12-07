<?php
$currentPage = basename($_SERVER['PHP_SELF']); // Get the current file name

// Include database connection
include '../config.php';

// Fetch department name based on session email
if (isset($_SESSION['email'])) {
    $stmt = $pdo->prepare("SELECT dname FROM department WHERE demail = :email");
    $stmt->bindParam(':email', $_SESSION['email'], PDO::PARAM_STR);
    $stmt->execute();
    $department = $stmt->fetch(PDO::FETCH_ASSOC);

    // Store department name in session
    if ($department) {
        $_SESSION['dname'] = $department['dname'];  // Save the department name to session
    }
}
?>

<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="index.php" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary" style="font-size: 15px; display: block; padding-left: 40px; margin-bottom: -35px;">
                ST JOSEPH ENGINEERING <br> COLLEGE MANGALORE
            </h3>
            <img class="logo" src="img/SJECLogo.png" alt="" style="width: 40px; height: 40px; display: block; margin-right: -10px; margin-top: -15px; gap: 15px;">
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <!-- <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;"> -->
                <!-- <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div> -->
            </div>
            <div class="ms-3">
                <!-- <h6 class="mb-0">Jhon Doe</h6> -->
                <span>Department of <Strong><?php echo htmlspecialchars($_SESSION['dname']); ?></Strong></span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <a href="index.php" class="nav-item nav-link <?php echo $currentPage == 'index.php' ? 'active' : ''; ?>">
                <i class="fa fa-tachometer-alt me-2"></i>Dashboard
            </a>

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle <?php echo in_array($currentPage, ['add_faculty.php', 'view_faculty.php', 'remove_faculty.php']) ? 'active' : ''; ?>" data-bs-toggle="dropdown">
                    <i class="fa fa-user"></i>&nbsp; Faculty
                </a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="view_faculty.php" class="dropdown-item <?php echo $currentPage == 'view_faculty.php' ? 'active' : ''; ?>">View Faculty</a>
                    <a href="view_faculty.php" class="dropdown-item <?php echo $currentPage == 'view_faculty.php' ? 'active' : ''; ?>">Assigned Subjects</a>
                </div>
                
            </div> 

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle <?php echo in_array($currentPage, ['add_faculty.php', 'view_faculty.php', 'remove_faculty.php']) ? 'active' : ''; ?>" data-bs-toggle="dropdown">
                    <i class="fa fa-graduation-cap"></i>&nbsp; Student
                </a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="import_students.php" class="dropdown-item <?php echo $currentPage == 'import_students.php' ? 'active' : ''; ?>">Add Student</a>
                </div>
            </div>
            
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle <?php echo in_array($currentPage, ['add_department.php', 'view_department.php', 'remove_department.php']) ? 'active' : ''; ?>" data-bs-toggle="dropdown">
                    <i class="fa fa-book me-2"></i>Subjects
                </a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="add_subject.php" class="dropdown-item <?php echo $currentPage == 'add_subject.php' ? 'active' : ''; ?>">Add Subjects</a>
                    <a href="view_subject.php" class="dropdown-item <?php echo $currentPage == 'view_subject.php' ? 'active' : ''; ?>">View Subjects</a>
                    <a href="view_department.php" class="dropdown-item <?php echo $currentPage == 'view_department.php' ? 'active' : ''; ?>">Assign Subjects</a>
                </div>
            </div>

        </div>
    </nav>
</div>
<!-- Sidebar End -->


      