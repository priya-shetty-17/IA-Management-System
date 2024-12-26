<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "internal_assessment";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data for students (example table: students)
$sql = "SELECT id, name, email FROM students";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOD Module - Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            color: #333;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            background: #007acc;
            color: white;
            padding: 20px;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            padding: 10px 15px;
            color: white;
            text-decoration: none;
            margin-bottom: 10px;
            border-radius: 5px;
            font-size: 1rem;
        }

        .sidebar a:hover {
            background: #005fa3;
        }

        .main-content {
            margin-left: 270px;
            padding: 20px;
        }

        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .card h3 {
            margin: 0;
            margin-bottom: 10px;
        }

        .charts {
            display: flex;
            gap: 20px;
        }

        .chart {
            flex: 1;
            height: 300px;
            background: #f4f4f4;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background: #007acc;
            color: white;
        }

        footer {
            text-align: center;
            padding: 10px 0;
            background: #f4f4f4;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>HOD Dashboard</h2>
        <a href="#home" onclick="showSection('home')">Home</a>
        <a href="#students" onclick="showSection('students')">Manage Students</a>
        <a href="#staff" onclick="alert('Coming Soon')">Manage Staff</a>
        <a href="#courses" onclick="alert('Coming Soon')">Manage Courses</a>
        <a href="#subjects" onclick="alert('Coming Soon')">Manage Subjects</a>
    </div>

    <div class="main-content">
        <section id="home" class="card">
            <h3>Welcome to the HOD Dashboard</h3>
            <p>Use the sidebar to navigate through different sections.</p>
        </section>

        <section id="students" class="card" style="display: none;">
            <h3>Manage Students</h3>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["email"] . "</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No records found</td></tr>";
                }
                ?>
            </table>
        </section>

        <section id="charts" class="charts">
            <div class="chart">
                <p>Chart 1 Placeholder</p>
            </div>
            <div class="chart">
                <p>Chart 2 Placeholder</p>
            </div>
        </section>
    </div>

    <footer>
        <p>&copy; 2024 HOD Dashboard. All rights reserved.</p>
    </footer>

    <script>
        function showSection(sectionId) {
            document.querySelectorAll('.card').forEach(card => card.style.display = 'none');
            document.getElementById(sectionId).style.display = 'block';
        }
    </script>
</body>
</html>
