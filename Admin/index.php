<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ADMIN Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/SJECLogo.png" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <style>
        .dashboard-card {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .dashboard-card h5 {
            color: #0d6efd;
            font-weight: 600;
        }

        .dashboard-card span {
            font-size: 1.5rem;
            font-weight: 700;
            color: #343a40;
        }
    </style>
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sidebar Start -->
       
        <?php include 'sidebar.php';?>
        <!-- Sidebar End -->


        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->

           <?php include 'navbar.php';?>
           
            <!-- Navbar End -->

            <!-- Subject -->
            <div class="container-fluid py-4">
    <div class="row g-4" id="department-cards">
        <div class="col-md-4">
            <div class="dashboard-card" onclick="loadSubjects(1001)">
                <h5>Department: MCA</h5>
                <p>Total IA Marks Updated: <strong>320</strong></p>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#iaMarksModal">View IA Marks</button>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-card" onclick="loadSubjects(1002)">
                <h5>Department: MBA</h5>
                <p>Total IA Marks Updated: <strong>320</strong></p>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#iaMarksModal">View IA Marks</button>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-card" onclick="loadSubjects(1006)">
                <h5>Department: Mechanical</h5>
                <p>Total IA Marks Updated: <strong>320</strong></p>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#iaMarksModal">View IA Marks</button>
            </div>
        </div>
    </div>

    <div class="mt-4" id="subjects-container">
        <h4>Subjects</h4>
    </div>
      <!-- IA Marks Modal -->
     
<div class="modal fade" id="iaMarksModal" tabindex="-1" aria-labelledby="iaMarksModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="iaMarksModalLabel">IA Marks for MCA</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        <strong>Data Structures</strong><br>
                        Faculty: Prof. John Doe<br>
                        Updated: <span class="text-success">120</span> IA Marks<br>
                        Pending: <span class="text-danger">0</span>
                    </li>
                    <li class="list-group-item">
                        <strong>Algorithms</strong><br>
                        Faculty: Dr. Jane Smith<br>
                        Updated: <span class="text-success">110</span> IA Marks<br>
                        Pending: <span class="text-danger">10</span>
                    </li>
                    <li class="list-group-item">
                        <strong>Database Management</strong><br>
                        Faculty: Prof. Robert Brown<br>
                        Updated: <span class="text-success">90</span> IA Marks<br>
                        Pending: <span class="text-danger">30</span>
                    </li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

</div>



<!-- Subject End -->
<script>
    function loadSubjects(departmentId) {
        const subjectsContainer = document.getElementById('subjects-container');
        subjectsContainer.innerHTML = '<p>Loading subjects...</p>'; // Show loading

        fetch(`getSubjects.php?deptid=${departmentId}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success' && Object.keys(data.subjects).length > 0) {
                    subjectsContainer.innerHTML = ''; // Clear previous subjects

                    Object.keys(data.subjects).forEach(semester => {
                        const semesterDiv = document.createElement('div');
                        semesterDiv.classList.add('mb-4'); // Margin bottom for spacing
                        semesterDiv.innerHTML = `
                            <h5>Semester ${semester}</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Subject Name</th>
                                        <th>Code</th>
                                        <th>Credits</th>
                                        <th>Total Hours</th>
                                    </tr>
                                </thead>
                                <tbody id="semester-${semester}"></tbody>
                            </table>
                        `;

                        subjectsContainer.appendChild(semesterDiv);

                        const semesterTable = document.getElementById(`semester-${semester}`);
                        data.subjects[semester].forEach(subject => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${subject.name}</td>
                                <td>${subject.code}</td>
                                <td>${subject.credit}</td>
                                <td>${subject.total_hour}</td>
                            `;
                            semesterTable.appendChild(row);
                        });
                    });
                } else {
                    subjectsContainer.innerHTML = '<p>No subjects found for this department.</p>';
                }
            })
            .catch(error => {
                console.error('Error fetching subjects:', error);
                subjectsContainer.innerHTML = '<p>Failed to load subjects. Please try again.</p>';
            });
    }
</script>


           
        </div>
        <!-- Content End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>