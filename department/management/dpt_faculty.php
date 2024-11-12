<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Management</title>
    <link rel="stylesheet" href="../department/css/faculty.css">
</head>
<body>
    <!-- Header -->
    <?php 
        include '../department/include/header.php';
        ?>

    <div class="container">
        <h1>Faculty Management</h1>
        <p class="description">Add new faculty to the department database. All fields are mandatory.</p>

        <!-- Faculty Form -->
        <form action="add_faculty.php" method="POST" enctype="multipart/form-data" class="faculty-form">
            <div class="form-group">
                <label for="name">Faculty Name:</label>
                <input type="text" id="name" name="name" placeholder="Enter faculty name" required>
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
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter password" required>
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
                <label for="role">Role:</label>
                <select id="role" name="role" required>
                    <option value="" disabled selected>Select Role</option>
                    <option value="Professor">Professor</option>
                    <option value="Assistant Professor">Assistant Professor</option>
                    <option value="Lecturer">Lecturer</option>
                </select>
            </div>

            <div class="form-group">
                <label for="profile_picture">Profile Picture:</label>
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*" required>
            </div>

            <button type="submit" class="btn-submit">Add Faculty</button>
        </form>
    </div>
</body>
</html>
