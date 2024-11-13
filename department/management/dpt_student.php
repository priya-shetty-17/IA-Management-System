<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
    <link rel="stylesheet" href="/Internal_assessment/department/css/student.css">
</head>
<body>
    <!-- Header -->
    <?php 
        include '../include/header.php';
    ?>

    <div class="container">
        <h1>Student Management</h1>
        <p class="description">Add new students to the department database. All fields are mandatory.</p>

        <!-- Student Form -->
        <form action="add_student.php" method="POST" enctype="multipart/form-data" class="student-form">
            <div class="form-group">
                <label for="name">Student Name:</label>
                <input type="text" id="name" name="name" placeholder="Enter student name" required>
            </div>

            <div class="form-group">
                <label for="usn">USN:</label>
                <input type="text" id="usn" name="usn" placeholder="Enter USN" required>
            </div>

            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter email address" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" placeholder="Enter phone number" required>
            </div>

            <div class="form-group">
                <label for="department">Department:</label>
                <select id="department" name="department" required>
                    <option value="" disabled selected>Select Department</option>
                    <option value="MCA">MCA</option>
                    <option value="CSE">CSE</option>
                    <option value="ECE">ECE</option>
                    <option value="EEE">EEE</option>
                    <option value="ME">ME</option>
                </select>
            </div>

            <div class="form-group">
                <label for="year">Year of Study:</label>
                <select id="year" name="year" required>
                    <option value="" disabled selected>Select Year</option>
                    <option value="1">1st Year</option>
                    <option value="2">2nd Year</option>
                    <option value="3">3rd Year</option>
                    <option value="4">4th Year</option>
                </select>
            </div>

            <div class="form-group">
                <label for="profile_picture">Profile Picture:</label>
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*" required>
            </div>

            <button type="submit" class="btn-submit">Add Student</button>
        </form>
    </div>
</body>
</html>
