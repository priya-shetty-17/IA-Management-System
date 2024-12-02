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
                <!-- <img class="rounded-circle" src="img/user.jpg" alt="" style="width: 40px; height: 40px;"> -->
                <!-- <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div> -->
            </div>
            <div class="ms-3">
                <!-- <h6 class="mb-0">Jhon Doe</h6> -->
                <span>Admin</span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <a href="index.php" class="nav-item nav-link <?php echo $currentPage == 'index.php' ? 'active' : ''; ?>">
                <i class="fa fa-tachometer-alt me-2"></i>Dashboard
            </a>

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle <?php echo in_array($currentPage, ['add_department.php', 'view_department.php', 'remove_department.php']) ? 'active' : ''; ?>" data-bs-toggle="dropdown">
                    <i class="fa fa-laptop me-2"></i>Department
                </a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="add_department.php" class="dropdown-item <?php echo $currentPage == 'add_department.php' ? 'active' : ''; ?>">Add Department</a>
                    <a href="view_department.php" class="dropdown-item <?php echo $currentPage == 'view_department.php' ? 'active' : ''; ?>">View Department</a>
                    <!-- <a href="update_department.php" class="dropdown-item <?php echo $currentPage == 'update_department.php' ? 'active' : ''; ?>">Update Department</a> -->
                </div>
            </div>

            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle <?php echo in_array($currentPage, ['add_faculty.php', 'view_faculty.php', 'remove_faculty.php']) ? 'active' : ''; ?>" data-bs-toggle="dropdown">
                    <i class="fa fa-laptop me-2"></i>Faculty
                </a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="add_faculty.php" class="dropdown-item <?php echo $currentPage == 'add_faculty.php' ? 'active' : ''; ?>">Add Faculty</a>
                    <a href="view_faculty.php" class="dropdown-item <?php echo $currentPage == 'view_faculty.php' ? 'active' : ''; ?>">View Faculty</a>
                    <a href="remove_faculty.php" class="dropdown-item <?php echo $currentPage == 'remove_faculty.php' ? 'active' : ''; ?>">Remove Faculty</a>
                </div>
            </div>

            <a href="roles.php" class="nav-item nav-link <?php echo $currentPage == 'roles.php' ? 'active' : ''; ?>">
                <i class="fa fa-th me-2"></i>Roles
            </a>

                <!-- 
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-laptop me-2"></i>Elements</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="button.html" class="dropdown-item">Buttons</a>
                            <a href="typography.html" class="dropdown-item">Typography</a>
                            <a href="element.html" class="dropdown-item">Other Elements</a>
                        </div>
                    </div>
                    <a href="widget.html" class="nav-item nav-link"><i class="fa fa-th me-2"></i>Widgets</a>
                    <a href="form.html" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Forms</a>
                    <a href="table.html" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Tables</a>
                    <a href="chart.html" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Charts</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="far fa-file-alt me-2"></i>Pages</a>
                        <div class="dropdown-menu bg-transparent border-0">
                            <a href="signin.html" class="dropdown-item">Sign In</a>
                            <a href="signup.html" class="dropdown-item">Sign Up</a>
                            <a href="404.html" class="dropdown-item">404 Error</a>
                            <a href="blank.html" class="dropdown-item">Blank Page</a>
                        </div>
                    </div> -->
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


      