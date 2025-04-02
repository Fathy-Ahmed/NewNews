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
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        nav {
            background: #28a745;
            padding: 30px; /* Height of navbar */
            text-align: center;
            position: relative;
        }
        nav a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            position: relative;
            font-size: 1.1em;
            margin-right: 20px; 
        }
        nav a:hover {
            background: #218838;
        }
        nav a.active {
            color: #fff;
            border-bottom: 2px solid white;
         }

        nav a::after {
            content: '';
            display: block;
            height: 2px;
            background: white;
            width: 100%;
            transform: scaleX(0);
            transition: transform 0.3s ease;
            position: absolute;
            left: 0;
            bottom: -5px; 
        }
        nav a:hover::after {
            transform: scaleX(1);
        }
        .new-news {
            font-weight: bold;
            font-size: 2em; 
            color: white;
            position: absolute;
            left: 20px; 
            top: 15px;
            text-decoration: underline;
        }
        .container {
            max-width: 600px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin: auto; /* Center the container */
            margin-top: 30px; /* Space from navbar */
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            text-align: left;
        }
        input[type="text"], input[type="email"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 4px;
            width: 100%;
            font-size: 1.1em; /* Increased font size */
        }
        input[type="submit"]:hover {
            background: #218838;
        }
    </style>
</head>
<body>

    <nav>
        <!-- <span class="new-news">New News </span><br><br> -->
        <a href="Home.php"><span class="news-news" style="font-weight: bolder;">New News </span></a>
        <a href="Sport.php">Sport </a>
        <a href="Business.php">Business </a>
        <a href="Earth.php">Earth </a>
        <a href="technology.php">Technology </a>
        <a class="active" href="contact_us.php">Contact Us</a>
        <?php 
                  if(isset($_SESSION['is_logedin'])&&$_SESSION['is_logedin']){ // he is logedin and have session
                    echo '<a href="Logout.php">Logout</a>';
                    $emaill=$_SESSION['emaill'];
                    //echo ''.$emaill.'<br>';
                    $sql = "SELECT Username FROM `user` WHERE Email=\"$emaill\";";
                    $result = mysqli_query($conn,$sql);
                    if(mysqli_num_rows($result)> 0){
                      $row = mysqli_fetch_assoc($result);
                      echo "<a class='nav-link' href='#'><span class='username' style='color: black'>Welcom {$row['Username']}</span></a>";
                    }
                  }else{
                    echo '<a href="login.php">Login</a>';
                  }
                ?>
    </nav>

    <div class="container">
        <h1>Contact Us</h1>
        <form action="" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="5" required>
                <?= isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '' ?>
            </textarea>

            <input type="submit" value="Send Message">
        </form>
    </div>

</body>
</html>