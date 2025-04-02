<?php
require 'connection.php';

$articleID = $_GET['id'] ?? null;

if (!$articleID) {
    die("Invalid article ID.");
}

 
$sql = "SELECT a.Title, a.Content, a.Image, a.PublishedAt, u.Username AS Author
        FROM article a
        JOIN user u ON a.AuthorID = u.UserID
        WHERE a.ArticleID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $articleID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Article not found.");
}

$article = $result->fetch_assoc();

 
$commentsSql = "SELECT c.Comment, c.CreatedAt, u.Username 
                FROM comment c
                JOIN user u ON c.UserID = u.UserID
                WHERE c.ArticleID = ?
                ORDER BY c.CreatedAt DESC";
$commentsStmt = $conn->prepare($commentsSql);
$commentsStmt->bind_param('i', $articleID);
$commentsStmt->execute();
$commentsResult = $commentsStmt->get_result();

 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userID = 3; // Example user (Replace with session user ID)
    $comment = $_POST['comment'];

    $addCommentSql = "INSERT INTO comment (ArticleID, UserID, Comment, CreatedAt) VALUES (?, ?, ?, NOW())";
    $addCommentStmt = $conn->prepare($addCommentSql);
    $addCommentStmt->bind_param('iis', $articleID, $userID, $comment);
    $addCommentStmt->execute();

    header("Location: news_id.php?id=$articleID");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $article['Title'] ?></title>
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
    <style>
        /* ==============================
           Global Styles
        ============================== */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* ==============================
           Article Section
        ============================== */
        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        img {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.1rem;
            margin-bottom: 15px;
        }

        small {
            color: #777;
        }

        article {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* ==============================
           Comments Section
        ============================== */
        .comments {
            margin-top: 30px;
        }

        .comment {
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 10px;
        }

        .comment p {
            font-size: 1rem;
            margin-bottom: 5px;
        }

        .comment small {
            font-size: 0.9rem;
            color: #777;
        }

        /* ==============================
           Comment Form Section
        ============================== */
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        textarea {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            border-radius: 8px;
            border: 1px solid #ddd;
            resize: vertical;
            margin-bottom: 15px;
        }

        button {
            background-color: #2ecc71;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
        }

        button:hover {
            background-color: #27ae60;
        }

        /* ==============================
           Responsive Design
        ============================== */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            h1 {
                font-size: 2rem;
            }

            textarea {
                font-size: 0.9rem;
            }

            button {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
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

    <article>
        <h1><?= $article['Title'] ?></h1>
        <img src="<?= $article['Image'] ?>" alt="News Image">
        <p><?= $article['Content'] ?></p>
        <p>Published at: <?= $article['PublishedAt'] ?> </p>
    </article>

    <section>
        <h2>Comments</h2>
        <div class="comments">
            <?php while ($comment = $commentsResult->fetch_assoc()): ?>
                <div class="comment">
                    <p><strong><?= $comment['Username'] ?>:</strong> <?= $comment['Comment'] ?></p>
                    <p><small><?= $comment['CreatedAt'] ?></small></p>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <section>
        <h2>Add a Comment</h2>
        <form action="" method="post">
            <textarea name="comment" required placeholder="Write your comment here..."></textarea>
            <button type="submit">Post Comment</button>
        </form>
    </section>

</body>
</html>
