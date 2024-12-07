<?php
require '././vendor/autoload.php'; // Load PhpSpreadsheet via Composer

use PhpOffice\PhpSpreadsheet\IOFactory;

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "internal_assessment";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['excel_file'])) {
    $uploadDir = './uploads/';
    $fileName = basename($_FILES['excel_file']['name']);
    $targetFilePath = $uploadDir . $fileName;

    // Ensure the uploads directory exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Upload the file to the server
    if (move_uploaded_file($_FILES['excel_file']['tmp_name'], $targetFilePath)) {
        try {
            // Load the spreadsheet
            $spreadsheet = IOFactory::load($targetFilePath);
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray();

            // Loop through each row
            foreach ($data as $index => $row) {
                if ($index == 0) {
                    // Skip the header row
                    continue;
                }

                // Assign values from columns
                $sid = $row[0];
                $sname = $row[1];
                $email = $row[2];
                $dob = $row[3];
                $usn = $row[4];
                $phone = $row[5];
                $deptid = $row[6];
                $year_of_study = $row[7];

                // Insert data into the database
                $stmt = $conn->prepare("INSERT INTO student (sid, sname, email, dob, usn, phone, deptid, year_of_study) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("issssisi", $sid, $sname, $email, $dob, $usn, $phone, $deptid, $year_of_study);

                if (!$stmt->execute()) {
                    $message .= "Error inserting row: " . $stmt->error . "<br>";
                }
            }

            $message .= "Data imported successfully!";
        } catch (Exception $e) {
            $message .= "Error loading file: " . $e->getMessage();
        }
    } else {
        $message .= "File upload failed!";
    }
}

// Fetch data to display
$students = [];
$result = $conn->query("SELECT * FROM student");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
}

// Close the connection
$conn->close();
?>


<!-- HTML Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Excel File</title>
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-sm-12 col-xl-6">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">File Input</h6>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="excel_file" class="form-label">Select Excel File</label>
                            <input class="form-control" type="file" name="excel_file" id="excel_file" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload and Import</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Imported Student Data</h6>
                    <p><?php echo $message; ?></p>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>SID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>DOB</th>
                                <th>USN</th>
                                <th>Phone</th>
                                <th>Department ID</th>
                                <th>Year of Study</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($students)): ?>
                                <?php foreach ($students as $student): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($student['sid']); ?></td>
                                        <td><?php echo htmlspecialchars($student['sname']); ?></td>
                                        <td><?php echo htmlspecialchars($student['semail']); ?></td>
                                        <td><?php echo htmlspecialchars($student['dob']); ?></td>
                                        <td><?php echo htmlspecialchars($student['usn']); ?></td>
                                        <td><?php echo htmlspecialchars($student['phone']); ?></td>
                                        <td><?php echo htmlspecialchars($student['deptid']); ?></td>
                                        <td><?php echo htmlspecialchars($student['year_of_study']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8">No data available.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

