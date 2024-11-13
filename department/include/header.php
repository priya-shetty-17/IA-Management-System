<?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $base_url = "/Internal_assessment/department/";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Home Page</title>
    <link rel="stylesheet" href="../css/home.css">
    <script src="../department/js/home.js" defer></script>
</head>
<body>


    <!-- Sidebar Section -->
    <div id="sidebar" class="sidebar">
        <div class="module-btn"><a href="../department/Management/dpt_faculty.php">Faculty Management</a></div>
        <div class="module-btn"><a href="../department/Management/dpt_student.php">Student Management</a></div>
        <div class="module-btn"><a href="../department/Management/dpt_subject.php">Subject Management</a></div>
        <div class="module-btn"><a href="../department/Management/dpt_attend.php">Attendance</a></div>
        <div class="module-btn"><a href="../department/Management/dpt_announce.php">Notifications & Announcements</a></div>
        <div class="module-btn"><a href="../department/Management/dpt_timetable.php">Timetable</a></div>
    </div>

    <!-- Top Navigation Bar (Header) -->
    <header class="nav-bar">
        <div class="hamburger" onclick="toggleSidebar()">
            <span></span>
            <span></span>
            <span></span>
        </div>
        
        
        <!-- Logo and College Info -->
        <img src="<?php echo $base_url; ?>images/sjec-logo.png" alt="College Logo" class="logo">
        <div class="college-info">
            <h1>St Joseph Engineering College, Vamanjoor - Mangalore</h1>
            <h2>Department of MCA</h2>
        </div>

            
        <!-- Profile Menu -->
        <div class="profile-menu">
        <img src="<?php echo $base_url; ?>images/profile.jpg" alt="Profile Icon" class="profile-icon">
            <div class="dropdown-content">
                <p>Welcome, <?php echo htmlspecialchars($_SESSION['dname']); ?></p>
                <a href="profile.php">View Profile</a>
                <a href="settings.php">Settings</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </header>

</body>
</html>
