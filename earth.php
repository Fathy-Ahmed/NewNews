<?php
  session_start();
  require 'connection.php';

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
    <!-- <link rel="stylesheet" href="css/section.css" /> -->
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
                    $sql = "SELECT Username FROM `user` WHERE Email=\"$emaill\";";
                    $result = mysqli_query($conn,$sql);
                    if(mysqli_num_rows($result)> 0){
                      $row = mysqli_fetch_assoc($result);
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

    <!-- Sport Sections -->
    <h1 class="headd" style="text-align: center;">Earth</h1>
    <div class="container2">
      <?php 
              $sql = "SELECT ArticleID,Title,Image,Content,PublishedAt FROM `article` WHERE CategoryID=4;";
              $result = mysqli_query($conn,$sql);
                    if(mysqli_num_rows($result)> 0){
                      while($row = mysqli_fetch_assoc($result)){
                        $ArticleID= $row['ArticleID'];
                        $Image= $row['Image'];
                        $Title= $row['Title'];
                        $Content= $row['Content'];
                        $PublishedAt= $row['PublishedAt'];
                        echo "<div class='card'>";
                        echo "<img src='$Image' alt='Space News 1'/>";
                        echo "<h3>$Title</h3>";
                        echo "<p>$Content</p>";
                        echo "<p>$PublishedAt</p>";
                        echo "<a href='news_id.php?id=$ArticleID'>Read More</a>";
                        echo "</div>";
                      }
                    }    
            ?>
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
