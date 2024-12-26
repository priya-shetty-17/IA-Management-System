<?php
$currentPage = basename($_SERVER['PHP_SELF']); // Get the current file name
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
                <!-- Placeholder for profile image -->
            </div>
            <div class="ms-3">
                <span>HOD</span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <p class="nav-item nav-link <?php echo $currentPage == 'index.php' ? 'active' : ''; ?>">
                <i class="fa fa-tachometer-alt me-2"></i>Dashboard
</p>

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle <?php echo in_array($currentPage, ['add_department.php', 'view_department.php']) ? 'active' : ''; ?>" data-bs-toggle="dropdown">
                    <i class="fa fa-laptop me-2"></i>Department
                </a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="view_department.php" class="dropdown-item <?php echo $currentPage == 'view_department.php' ? 'active' : ''; ?>">View Department</a>
                </div>
            </div>

            <!-- New Students Section -->
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle <?php echo in_array($currentPage, ['add_student.php', 'view_student.php']) ? 'active' : ''; ?>" data-bs-toggle="dropdown">
                    <i class="fa fa-user-graduate me-2"></i>Students
                </a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="view_student.php" class="dropdown-item <?php echo $currentPage == 'view_student.php' ? 'active' : ''; ?>">View Students</a>
                </div>
            </div>
        </div>
    </nav>
</div>
<!-- Sidebar End -->
