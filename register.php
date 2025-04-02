<?php
require 'connection.php';
$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!$_POST["name"]) {
        array_push($errors, "Name is required.<br>");
    } else if (strlen($_POST["name"]) < 6) {
        array_push($errors, "Name should be at least 6 characters.<br>");
    } else if (strlen($_POST["name"]) > 50) {
        array_push($errors, "Name should be less than 50 characters.<br>");
    }
    if (!$_POST["email"]) {
        array_push($errors, "Email is required.<br>");
    } else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $validate_email = htmlspecialchars($_POST["email"]);
        array_push($errors, "Email ($validate_email) is not valid.<br>");
    } else if (strlen($_POST["email"]) < 5) {
        array_push($errors, "Email should be at least 5 characters.<br>");
    } else if (strlen($_POST["email"]) > 50) {
        array_push($errors, "Email should be less than 50 characters.<br>");
    }
    if (!$_POST["password"]) {
        array_push($errors, "Password is required.<br>");
    } else if (strlen($_POST["password"]) < 8) {
        array_push($errors, "Password should be at least 8 characters.<br>");
    } else if (strlen($_POST["password"]) > 40) {
        array_push($errors, "Password should be less than 40 characters.<br>");
    }
    if (!$_POST["rpassword"]) {
        array_push($errors, "Retype password is required.<br>");
    } else if ($_POST["password"] !== $_POST["rpassword"]) {
        array_push($errors, "Password and Retype password do not match.<br>");
    }
    if (count($errors) == 0) {
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $account_name = htmlspecialchars($_POST["name"]);
        $account_mail = htmlspecialchars($_POST["email"]);
        $account_password = htmlspecialchars($_POST["password"]);
        $date=date("Y-m-d H:i:s");

        $account_name = mysqli_real_escape_string($conn, $account_name);
        $account_mail = mysqli_real_escape_string($conn, $account_mail);
        $account_password = mysqli_real_escape_string($conn, $account_password);
        $check_mail = "SELECT email FROM user WHERE email='$account_mail'";
        $result = mysqli_query($conn, $check_mail);
        $flag=0;
        if(mysqli_num_rows($result) > 0){
          array_push($errors,"the email is already exist please change the email");
          $flag=1;
        }
      if(!$flag){
        $query = "INSERT INTO `user`(`Username`, `Password`, `Email`,`RoleID`,`CreatedAt`) VALUES ('$account_name', '$account_password', '$account_mail',2,'$date')";
        if (mysqli_query($conn, $query)) {
            header("Location: login.php");
        } else {
            array_push($errors, "Error: " . mysqli_error($conn) . "<br>");
        }
        mysqli_close($conn);
      }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/register.css">
    <title>Register</title>
</head>
<body>
<section class="vh-100 bg-image" style="background-image: url(img/login.jpg);">
  <div class="mask d-flex align-items-center h-100 gradient-custom-3">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
          <div class="card" style="border-radius: 15px;">
            <div class="card-body p-5">
              <div class="logo-section">
                  <a href="/newnews" class="logo-link">NEW NEWS</a>
              </div>
              <h2 class="text-center mb-5">Sign up for your NEW NEWS account</h2>
              <?php if (isset($errors) && count($errors) > 0) { ?>
              <div class="alert alert-danger">
                <ul class="my-0 list-unstyled">
                  <?php foreach ($errors as $error) { ?>
                    <li><?php echo $error; ?></li>
                  <?php } ?>
                </ul>
              </div>
            <?php } ?>
              <form action="" method="POST">
                <div class="form-outline mb-4">
                  <input type="text" id="form3Example1cg" name="name" class="form-control form-control-lg"  />
                  <label class="form-label" for="form3Example1cg">Your Name</label>
                </div>
                <div class="form-outline mb-4">
                  <input type="email" id="form3Example3cg" name="email" class="form-control form-control-lg"  />
                  <label class="form-label" for="form3Example3cg">Your Email</label>
                </div>
                <div class="form-outline mb-4">
                  <input type="password" id="form3Example4cg" name="password" class="form-control form-control-lg"  />
                  <label class="form-label" for="form3Example4cg">Password</label>
                </div>
                <div class="form-outline mb-4">
                  <input type="password" id="form3Example4cdg" name="rpassword" class="form-control form-control-lg"  />
                  <label class="form-label" for="form3Example4cdg">Repeat your password</label>
                </div>
                <div class="form-check d-flex justify-content-center mb-5">
                  <input class="form-check-input me-2" type="checkbox" id="form2Example3cg"  />
                  <label class="form-check-label" for="form2Example3cg">
                    I agree to all statements in <a href="#!" class="text-body"><u>Terms of service</u></a>
                  </label>
                </div>
                <div class="d-flex justify-content-center">
                  <button type="submit" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Register</button>
                </div>
                <p class="text-center text-muted mt-5 mb-0">Already have an account? 
                  <a href="login.php" class="fw-bold text-body text-decoration-none"><u>Login here</u></a>
                </p>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>