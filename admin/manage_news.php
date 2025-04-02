<?php
session_start();
  require 'db.php';
  $query = "SELECT article.ArticleID, article.Title, category.Name AS Category, user.Username AS Author, article.PublishedAt 
          FROM article
          JOIN category ON article.CategoryID = category.CategoryID
          JOIN user ON article.AuthorID = user.UserID";
$stmt = $conn->prepare($query);
$stmt->execute();
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manage News</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="../css/manage_news.css" />
  </head>
  <body>
    <div class="sidebar">
      <h2><a href="/newnews">New News</a></h2>
      <a href="AdminPanel.php">📊 Dashboard</a>
      <a href="manage_news.html">📰 Manage News</a>
      <a href="manage_user.php">👥 Manage Users</a>
      <a href="manage_message.php">✉️ User Messages</a>
      <div class="logout-btn">
        <a href="logout.php">🔓 Logout</a>
      </div>
    </div>

    <div class="main-content">
      <h1>📰 Manage News</h1>

      <div class="actions">
        <button class="btn btn-success add-btn">
          <i class="fas fa-plus"></i> 
          <a href="add_news.php">Add News</a>
        </button>
      </div>

      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Category</th>
            <th>Author</th>
            <th>Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($articles as $article): ?>
                <tr>
                    <td><?= $article['ArticleID'] ?></td>
                    <td><?= $article['Title'] ?></td>
                    <td><?= $article['Category'] ?></td>
                    <td><?= $article['Author'] ?></td>
                    <td><?= $article['PublishedAt'] ?></td>
                    <td>
                        <a href="edit_news.php?id=<?= $article['ArticleID'] ?>" class="action-btn edit-btn">Edit</a>
                        <a href="delete_news.php?id=<?= $article['ArticleID'] ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  </body>
</html>
