<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="../assets/sjec_logo.png" rel="icon">
  <title>Faculty Login - IA Management System</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../css/department.css" rel="stylesheet">
</head>

<body class="bg-gradient-login" style="background:url('../assets/sjec.jpg') no-repeat center center fixed; background-size: cover;">
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
                    <img src="../assets/sjec_logo.png" style="width:100px;height:100px">
                    <br><br>
                    <h1 class="h4 text-gray-900 mb-4">Faculty Login</h1>
                  </div>
                  <form method="POST" action="">
                    <div class="form-group">
                      <input type="email" class="form-control" required name="femail" placeholder="Enter Email Address">
                    </div>
                    <div class="form-group">
                      <input type="password" name="fpassword" required class="form-control" placeholder="Enter Password">
                    </div>
                    <div class="form-group">
                      <input type="submit" class="btn btn-success w-100" value="Login" name="login" style="background-color: #007bff; color: white;">
                    </div>
                  </form>

                  <!-- PHP Code for Login -->
                  <?php
                  session_start();
                  include('../config.php');

                  if (isset($_POST['login'])) {
                      $femail = $_POST['femail'];
                      $fpassword = md5($_POST['fpassword']);

                      // Check the credentials in the faculty table
                      $query = "SELECT * FROM faculty WHERE femail = '$femail' AND fpassword = '$fpassword'";
                      $result = $conn->query($query);
                      $num = $result->num_rows;
                      $row = $result->fetch_assoc();

                      if ($num > 0) {
                          // Set session variables
                          $_SESSION['facid'] = $row['facid'];
                          $_SESSION['fname'] = $row['fname'];
                          $_SESSION['femail'] = $row['femail'];
                          $_SESSION['frole'] = $row['frole'];
                          $_SESSION['deptid'] = $row['deptid'];

                          // Redirect to the Faculty Dashboard
                          echo "<script type='text/javascript'>
                          window.location = ('department/department.php');
                          </script>";
                      } else {
                          echo "<div class='alert alert-danger text-center' role='alert'>
                          Invalid Email or Password!
                          </div>";
                      }
                  }
                  ?>
                  <div class="text-center">
                    <a href="../index.html">Back to Home</a>
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
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="../js/ruang-admin.min.js"></script>
</body>

</html>
