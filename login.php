<?php
session_start();
require 'connection.php';
if(isset($_SESSION['is_logedin'])&&$_SESSION['is_logedin']){ // he is logedin and have session
  header('location:home.php');
  return;
}
$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["email"]) || empty($_POST["email"])) {
        array_push($errors, "Email is Required<br>");
    }
    if (!isset($_POST["password"]) || empty($_POST["password"])) {
        array_push($errors, "Password is Required<br>");
    } else if (strlen($_POST["password"]) < 8) {
        array_push($errors, "Password should be more than or equal to 8 characters<br>");
    } else if (strlen($_POST["password"]) > 40) {
        array_push($errors, "Password should be less than 40 characters<br>");
    }
    if(!$errors){
        $email=htmlspecialchars( $_POST['email']);
        $pass=htmlspecialchars($_POST['password']);
        $hash=password_hash($pass,PASSWORD_DEFAULT);
        $username = mysqli_real_escape_string($conn, $email); // to secure from sqli and set \ before the char
        $password = mysqli_real_escape_string($conn, $pass); // to secure from sqli and set \ before the char
        $query1 = mysqli_query($conn, "SELECT email FROM user WHERE email='$username'");
        $query2 = mysqli_query($conn, "SELECT password FROM user WHERE email='$username'");
        $query3 = mysqli_query($conn, "SELECT RoleID FROM user WHERE email='$username'");
        $flag1 = 0;
        // store the result
        $username_result = mysqli_fetch_assoc($query1);
        $password_result = mysqli_fetch_assoc($query2);
        // store the resutl
        if (!$username_result) {
            $flag1 = 1;
        } else if (!$password_result) {
            $flag1 = 1;
        }
        $flag2 = 0; 
        if (!$flag1){
            if(($username_result['email']) ==NULL) { // check the username is exist or no 
                array_push($errors, "The username or password is incorrect<br>");
                $flag2 = 1;
        }
        else if ($username_result['email'] !== $username) { // check the username is ture or fasle
            array_push($errors, "The username or password is incorrect<br>");
            $flag2 = 1;
        }
        else if(($password_result['password'])==NULL) { // check the password is exist or no
                array_push($errors, "The username or password is incorrect<br>");
                $flag2 = 1;
        }
        else if ($password_result['password'] !== $password) { // check the password is true or false
            array_push($errors, "The username or password is incorrect<br>");
            $flag2 = 1;
        }
        if (!$flag2) {
            session_start();
            $_SESSION['username']=$username_result;
            $_SESSION['is_logedin']=true;
            $_SESSION['emaill']=$username;
            if(mysqli_num_rows($query3)>0){
              $rrow=mysqli_fetch_assoc($query3);
              if($rrow['RoleID']==1){
                header("location:/newnews/admin/adminpanel.php");
              }else{
                header("location:home.php");
              }
            }
            return;
        }else{
            //print_r($errors);
        }
        }else{
            array_push($errors, "The username or password is incorrect<br>");
        }
         //$_SESSION['errors']=$errors; 
    }else{
      //session_start();
      //$_SESSION['errors']=$errors;
      header('location:login.php');
      return;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css">
    <title>Login</title>
</head>
<body>
<section class="vh-100 bg-image"
  style="background-image: url(img/login.jpg);">
  <div class="mask d-flex align-items-center h-100 gradient-custom-3">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
          <div class="card" style="border-radius: 15px;">
            <div class="card-body p-5">
              <div class="logo-section">
                  <a href="/newnews" class="logo-link">NEW NEWS</a>
              </div>
              <h2 class="text-uppercase text-center mb-5">Sign in to your NEW NEWS account</h2>
              <?php if ((isset($errors) && count($errors)) > 0) { ?>
                <div class="alert alert-danger">
                  <ul class="my-0 list-unstyled">
                    <?php foreach ($errors as $error) { ?>
                      <li><?php echo $error; ?></li>
                    <?php } ?>
                  </ul>
                </div>
                <?php #unset($_SESSION['errors']);?>
              <?php } ?>
              <form action="" method="POST">
                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="email" id="form3Example3cg" name="email" class="form-control form-control-lg" required />
                  <label class="form-label" for="form3Example3cg">Your Email</label>
                </div>
                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="password" id="form3Example4cg" name="password" class="form-control form-control-lg" required />
                  <label class="form-label" for="form3Example4cg">Password</label>
                </div>
                <div class="form-check d-flex justify-content-center mb-4">
                  <input class="form-check-input me-2" type="checkbox" id="form2Example3cg" />
                  <label class="form-check-label" for="form2Example3cg">
                    Remember me
                  </label>
                </div>
                <div class="text-center mb-3">
                  <a href="reset_password.php" class="text-body"><u>Forgot password?</u></a>
                </div>
                <div class="d-flex justify-content-center">
                  <button type="submit" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Login</button>
                </div>
                <p class="text-center text-muted mt-5 mb-0">Don't have an account? 
                  <a href="register.php" class="fw-bold text-body text-decoration-none"><u>Register here</u></a>
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