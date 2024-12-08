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
        <!-- Cards for Departments -->
        <div class="col-md-4" onclick="loadSubjects(1)">
            <div class="dashboard-card">
                <h5>Department: MCA</h5>
                <p class="mb-0">IA Marks Updated:</p>
                <span>25</span>
            </div>
        </div>
        <div class="col-md-4" onclick="loadSubjects(2)">
            <div class="dashboard-card">
                <h5>Department: MBA</h5>
                <p class="mb-0">IA Marks Updated:</p>
                <span>30</span>
            </div>
        </div>
        <div class="col-md-4" onclick="loadSubjects(3)">
            <div class="dashboard-card">
                <h5>Department: Mechanical</h5>
                <p class="mb-0">IA Marks Updated:</p>
                <span>20</span>
            </div>
        </div>
    </div>

    <!-- Subject Details -->
    <div class="mt-4" id="subjects-container">
        <h4>Subjects</h4>
        <div id="subjects-list" class="row g-3"></div>
    </div>
</div>



             <!-- Subject End -->
             <script>
    function loadSubjects(departmentId) {
        const subjectsList = document.getElementById('subjects-list');
        subjectsList.innerHTML = '<p>Loading subjects...</p>'; // Loading indicator

        fetch(`getSubjects.php?deptid=${departmentId}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    subjectsList.innerHTML = ''; // Clear previous content

                    // Populate subjects dynamically
                    data.subjects.forEach(subject => {
                        const subjectCard = document.createElement('div');
                        subjectCard.classList.add('col-md-4');
                        subjectCard.innerHTML = `
                            <div class="dashboard-card">
                                <h5>${subject.name}</h5>
                                <p class="mb-0">Marks Updated:</p>
                                <span>${subject.marks_updated}</span>
                            </div>`;
                        subjectsList.appendChild(subjectCard);
                    });
                } else {
                    subjectsList.innerHTML = `<p>${data.message}</p>`;
                }
            })
            .catch(error => {
                console.error('Error fetching subjects:', error);
                subjectsList.innerHTML = '<p>Failed to load subjects. Please try again.</p>';
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