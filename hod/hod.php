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
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
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

        .section-card {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }

        .section-card h5 {
            font-size: 1.25rem;
            color: #495057;
        }

        .back-button {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .back-button i {
            font-size: 1.2rem;
            color: #0d6efd;
        }

        .back-button:hover {
            text-decoration: underline;
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
        <?php include 'sidebar.php'; ?>
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <?php include 'navbar.php'; ?>
            <!-- Navbar End -->

            <!-- Main Content -->
            <div class="container-fluid py-4">
                <!-- Back Button -->
                <div class="back-button" onclick="goBack()">
                    <i class="bi bi-arrow-left"></i>
                    <span>Back</span>
                </div>

                <!-- Department Cards -->
                <div class="row g-4" id="department-cards">
                    <div class="col-md-4" onclick="loadSemesterSections(1)">
                        <div class="dashboard-card">
                            <h5>Department: MCA</h5>
                            <p class="mb-0">IA Marks Updated:</p>
                            <span>25</span>
                        </div>
                    </div>
                    <div class="col-md-4" onclick="loadSemesterSections(2)">
                        <div class="dashboard-card">
                            <h5>Department: MBA</h5>
                            <p class="mb-0">IA Marks Updated:</p>
                            <span>30</span>
                        </div>
                    </div>
                    <div class="col-md-4" onclick="loadSemesterSections(3)">
                        <div class="dashboard-card">
                            <h5>Department: Mechanical</h5>
                            <p class="mb-0">IA Marks Updated:</p>
                            <span>20</span>
                        </div>
                    </div>
                </div>

                <!-- Semester Sections -->
                <div class="mt-4" id="semester-sections" style="display: none;">
                    <h4>Semester Sections</h4>
                    <div id="sections-list" class="row g-3"></div>
                </div>
            </div>

            <!-- Back to Top -->
            <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
        </div>
        <!-- Content End -->

        <!-- JavaScript Logic -->
        <script>
            function loadSemesterSections(departmentId) {
                const sectionsList = document.getElementById('sections-list');
                const semesterSections = {
                    1: ['Sem 1 A', 'Sem 1 B', 'Sem 2 A', 'Sem 2 B', 'Sem 3 A', 'Sem 3 B'],
                    2: ['Sem 1 A', 'Sem 1 B', 'Sem 2 A', 'Sem 2 B', 'Sem 3 A', 'Sem 3 B'],
                    3: ['Sem 1 A', 'Sem 1 B', 'Sem 2 A', 'Sem 2 B', 'Sem 3 A', 'Sem 3 B']
                };

                // Show Semester Sections Container
                document.getElementById('semester-sections').style.display = 'block';

                // Clear previous content
                sectionsList.innerHTML = '';

                // Populate sections dynamically based on departmentId
                semesterSections[departmentId].forEach(section => {
                    const sectionCard = document.createElement('div');
                    sectionCard.classList.add('col-md-4');
                    sectionCard.innerHTML = `
                        <div class="section-card">
                            <h5>${section}</h5>
                        </div>`;
                    sectionsList.appendChild(sectionCard);
                });

                // Hide department cards
                document.getElementById('department-cards').style.display = 'none';
            }

            function goBack() {
                const departmentCards = document.getElementById('department-cards');
                const semesterSections = document.getElementById('semester-sections');

                // Show department cards and hide semester sections
                departmentCards.style.display = 'flex';
                semesterSections.style.display = 'none';
            }
        </script>

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
    </div>
</body>

</html>