<?php
session_start();
require 'connection.php';
$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["email"]) || empty($_POST["email"])) {
        array_push($errors, "Email is required.<br>");
    }
    if (!isset($_POST["name"]) || empty($_POST["name"])) {
        array_push($errors, "Name is required.<br>");
    } else if (strlen($_POST["name"]) < 8) {
        array_push($errors, "Name should be at least 8 characters long.<br>");
    } else if (strlen($_POST["name"]) > 100) {
        array_push($errors, "Name should be less than 100 characters.<br>");
    }
    if (!isset($_POST['message']) || empty($_POST['message'])) {
        array_push($errors, "Message is required.<br>");
    } else if (strlen($_POST["message"]) < 20) {
        array_push($errors, "Message should be at least 20 characters long.<br>");
    } else if (strlen($_POST["message"]) > 1000) {
        array_push($errors, "Message should be less than 1000 characters.<br>");
    }
    if (!$errors) {
       
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $message = htmlspecialchars($_POST['message']);
        $store_name = mysqli_real_escape_string($conn, $name);
        $store_email = mysqli_real_escape_string($conn, $email);
        $store_message = mysqli_real_escape_string($conn, $message);

        $sql = "INSERT INTO Message(username, email_message, message_content) 
                VALUES ('$store_name', '$store_email', '$store_message')";

        if (mysqli_query($conn, $sql)) {
            header('location:home.php');
            exit;
        } else {
            array_push($errors, "Failed to submit your message: " . mysqli_error($conn) . "<br>");
        }
        mysqli_close($conn);
    }
    else{
        foreach ($errors as $error) {
            echo "<div style='color: red; text-align: center;'>$error</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>New News</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@400;700&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
    <link rel="stylesheet" href="css/home.css" />
  </head>
  <body>
    <!-- Breaking News -->
    <div class="breaking-news">
      <p>Breaking News: Robot Attack on Benha Computer Agent!</p>
    </div>
    <!-- Header -->
    <header>
      <div class="container">
        <nav class="navbar navbar-expand-lg sticky-top">
          <div class="container-fluid">
            <a class="navbar-brand" href="/newnews"
              ><i class="fas fa-home"></i> New News</a
            >
            <button
              class="navbar-toggler"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#navbarNav"
            >
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                  <a class="nav-link" href="sport.php"
                    ><i class="fas fa-basketball-ball"></i> Sport</a
                  >
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="business.php"
                    ><i class="fas fa-briefcase"></i> Business</a
                  >
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="earth.php"
                    ><i class="fas fa-rocket"></i> Earth</a
                  >
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="technology.php"
                    ><i class="fas fa-laptop"></i> Technology</a
                  >
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="contact_us.php"
                    ><i class="fas fa-envelope"></i> Contact Us</a
                  >
                </li>
                <?php 
                  if(isset($_SESSION['is_logedin'])&&$_SESSION['is_logedin']){ // he is logedin and have session
                    echo '<li class="nav-item">
                          <a class="nav-link" href="Logout.php">
                            <i class="fas fa-sign-out-alt"></i> Logout
                          </a>
                        </li>';
                    $emaill=$_SESSION['emaill'];
                    //echo ''.$emaill.'<br>';
                    $sql = "SELECT * FROM `user` WHERE Email=\"$emaill\";";
                    $result = mysqli_query($conn,$sql);
                    if(mysqli_num_rows($result)> 0){
                      $row = mysqli_fetch_assoc($result);
                      if($row["RoleID"] == 1){
                        echo '<li class="nav-item">
                          <a class="nav-link" href="/newnews/admin/adminpanel.php">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                          </a>
                        </li>';
                      }
                      echo "<li class='nav-item username'><a class='nav-link' href='#'><span class='username' style='color: black'>Welcom {$row['Username']}</span></a></li>";
                    }
                  }else{
                    echo '<li class="nav-item">
                          <a class="nav-link" href="login.php">
                            <i class="fas fa-user"></i> Login
                          </a>
                        </li>';
                  }
                ?>
              </ul>
            </div>
          </div>
        </nav>
      </div>
    </header>        
    <!-- News Sections -->
     
    <div style="width: 50%; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 2px 2px 10px rgba(0,0,0,0.1);">
    <h1 style="text-align: center; font-family: Arial, sans-serif;">Contact Us</h1>
    <form action="" method="POST">
        <label for="name" style="display: block; margin-bottom: 5px; font-weight: bold;">Name:</label>
        <input type="text" id="name" name="name" value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>" required 
               style="width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;">
        
        <label for="email" style="display: block; margin-bottom: 5px; font-weight: bold;">Email:</label>
        <input type="email" id="email" name="email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" required 
               style="width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;">

        <label for="message" style="display: block; margin-bottom: 5px; font-weight: bold;">Message:</label>
        <textarea id="message" name="message" rows="5" required 
                  style="width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;">
                  <?= isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '' ?>
                </textarea>

            <input type="submit" value="Send Message" 
                   style="width: 100%; padding: 10px; background-color: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer;">
        </form>
    </div>

    
    <!-- Footer -->
    <footer id="contact">
      <div class="container d-flex justify-content-between align-items-center">
        <div>
          <p>&copy; 2024 New News. All Rights Reserved.</p>
          <div class="social-icons">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
          </div>
        </div>
        <form
          action="contact_process.php"
          method="POST"
          class="footer-email-form"
        >
          Enter your email to subscribe to the newsletter<br />
          <input
            type="email"
            name="email"
            placeholder="Enter your email"
            required
          />
          <button type="submit">Subscribe</button>
        </form>
      </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
  </body>
</html>
