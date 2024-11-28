<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  
  <!-- Update the favicon path -->
  <link href="assets/sjec_logo.png" rel="icon">
  
  <title>IA Management System</title>
  
  <!-- Update CSS paths -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/department.css" rel="stylesheet">
</head>

<body class="bg-gradient-login" style="background:url('assets/sjec.jpg') no-repeat center center fixed; background-size: cover;">
  <!-- Login Content -->
  <div class="container-login">
    <div class="row justify-content-center">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <h5 class="text-center">IA Management System</h5>
                  <div class="text-center">
                    <!-- Update logo path -->
                    <img src="assets/sjec_logo.png" style="width:100px;height:100px">
                    <br><br>
                    <h1 class="h4 text-gray-900 mb-4">User Login</h1>
                  </div>
                  <form method="POST" action="">
                    <div class="form-group">
                      <input type="email" class="form-control" required name="email" placeholder="Enter Email Address">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" required name="dpassword" placeholder="Enter Password">
                    </div>

                    <div class="form-group">
                      <input type="submit" class="btn btn-success w-100" value="Login" name="login" style="background-color: #007bff; color: white;">
                    </div>
                  </form>

                
<?php
session_start();
include 'config.php'; // Database connection file

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['dpassword'];

    try {
        // Query to check all tables
        $query = "
            SELECT admin_email AS email, admin_pass AS password, role, 'admin' AS user_type FROM admin
            UNION ALL
            SELECT demail AS email, dpassword AS password, role, 'department' AS user_type FROM department
            UNION ALL
            SELECT femail AS email, fpass AS password, role, 'faculty' AS user_type FROM faculty
            UNION ALL
            SELECT hemail AS email, hpass AS password, role, 'hod' AS user_type FROM hod
            UNION ALL
            SELECT pemail AS email, ppass AS password, role, 'principal' AS user_type FROM principal
            UNION ALL
            SELECT semail AS email, spass AS password, role, 'student' AS user_type FROM student
        ";

        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $user_found = false;
        foreach ($users as $user) {
            if ($user['email'] === $email && $user['password'] === $password) {
                $user_found = true;

                // Set session variables
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['user_type'] = $user['user_type'];

                // Redirect based on role
                switch ($user['role']) {
                    case 1:
                        header('Location: admin/index.php');
                        break;
                    case 2:
                        header('Location: dpt/dpt.php');
                        break;
                      
                    case 3:
                        header('Location: fac.html');
                        break;
                    case 4:
                        header('Location: hod.html');
                        break;
                    case 5:
                        header('Location: princi.html');
                        break;
                    case 6:
                        header('Location: stud.html');
                        break;
                    default:
                        throw new Exception('Invalid role!');
                }
                exit;
            }
        }

        if (!$user_found) {
            echo "<div class='alert alert-danger text-center'>Invalid Email or Password!</div>";
        }
    } catch (Exception $e) {
        echo "<div class='alert alert-danger text-center'>Error: " . $e->getMessage() . "</div>";
    }
}
?>




                  <div class="text-center">
                    <a href="index.html">Back to Home</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End of Login Content -->

  <!-- Update script paths -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
</body>

</html>
