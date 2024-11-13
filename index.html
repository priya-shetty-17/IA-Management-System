<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="../assets/sjec_logo.png" rel="icon">
  <title>Department Login - IA Management System</title>
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
                    <h1 class="h4 text-gray-900 mb-4">Department Login</h1>
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
include('../config.php');

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $dpassword = $_POST['dpassword'];

    // Prepared statement to prevent SQL injection
    $query = "SELECT * FROM department WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['email' => $email]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify the password using password_verify if stored using password_hash
    if ($row && password_verify($dpassword, $row['dpassword'])) {
        // Set session variables
        $_SESSION['deptid'] = $row['deptid'];
        $_SESSION['dname'] = $row['dname'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['hod_id'] = $row['hod_id'];

        // Redirect to the Department Dashboard
        header('Location: department.php');
        exit;
    } else {
        // Show error message for invalid credentials
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
