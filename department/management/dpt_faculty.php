<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Management</title>
    <link rel="stylesheet" href="../css/faculty.css">
</head>
<body>

    <h1>Faculty Management</h1>

    <!-- Faculty Form -->
    <form action="add_faculty.php" method="POST" enctype="multipart/form-data">
        <label for="name">Faculty Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" required>

        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="Professor">Professor</option>
            <option value="Assistant Professor">Assistant Professor</option>
            <option value="Lecturer">Lecturer</option>
        </select>

        <label for="profile_picture">Profile Picture:</label>
        <input type="file" id="profile_picture" name="profile_picture" accept="image/*" required>

        <button type="submit">Add Faculty</button>
    </form>

</body>
</html>
