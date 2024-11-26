<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Module - Homepage</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Head Of Department</h1>
            <p>Department for managing assessments, attendance!</p>
            <a href="#dashboard" class="button">View Dashboard</a>
        </div>
    </header>

    <!-- Single Dashboard Section -->
    <section id="dashboard" style="display: none;">
        <div class="feature">            
            <div class="dashboard-links">
                <!-- The button now redirects to view_assessments.html when clicked -->
                <button onclick="location.href='view_assessments.html'">View Faculty</button>
                <button onclick="openFeature('attendance')">View Student </button>
                <button onclick="openFeature('attendance')">View Department </button>

            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 Student Module. All rights reserved.</p>
    </footer>

    <script>
        // JavaScript to toggle the dashboard view
        document.querySelector('.button').addEventListener('click', function() {
            document.getElementById('dashboard').style.display = 'block';
        });

        // Placeholder function for handling feature navigation
        function openFeature(feature) {
            if (feature === 'attendance') {
                alert("Opening attendance section...");
                // Add code to open the attendance page if needed
            }
        }
    </script>
</body>
</html>
