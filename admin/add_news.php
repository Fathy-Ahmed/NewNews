<?php
session_start();
  require 'db.php';
  $connnnn=mysqli_connect($host,
                          $user,
                          $pass,
                          $db);
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $authorID = $_POST['author'];
    $categoryID = $_POST['category'];
    $publishedAt = date('Y-m-d H:i:s');
    $categoryQuery = mysqli_query($connnnn,"select Name from category where CategoryID=$categoryID");
    $rrrow = mysqli_fetch_assoc($categoryQuery);
    if(isset($_FILES['photo'])){
        if($_FILES['photo']['error']==UPLOAD_ERR_OK){
            $extention=explode('.',$_FILES['photo']['name']);
            $new_name=time().'.'.$extention[count($extention)-1];
            $upload_dir = "../img/news/" . $rrrow['Name'] . "/";

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true); // Create the directory if it doesn't exist
            }
            $destination = $upload_dir . $new_name;
            $trimmed_path = ltrim($destination, '.');
            $trimmed_path = ltrim($trimmed_path, '/');
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
                echo "File uploaded successfully to: $destination";
            } else {
                echo "Failed to upload file.";
            }
        }else {
            echo "Error in file upload: " . $_FILES['photo']['error'];
        }
    }

    $query = "INSERT INTO article (Title, Content, AuthorID, CategoryID, PublishedAt, Status, Image) 
              VALUES (:title, :content, :author, :category, :publishedAt, 'Published', :image)";
    $stmt = $conn->prepare($query);
    $stmt->execute([
        ':title' => $title,
        ':content' => $content,
        ':author' => $authorID,
        ':category' => $categoryID,
        ':publishedAt' => $publishedAt,
        ':image' => $trimmed_path
    ]);

    header('Location: manage_news.php');
}
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
      <h1 style="text-align: center; font-weight: bolder;">Add News</h1>
      <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-control" id="category" name="category" required>
                    <?php
                    $categories = $conn->query("SELECT * FROM category")->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($categories as $category) {
                        echo "<option value='{$category['CategoryID']}'>{$category['Name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Photo</label>
                <input type="file" class="form-control" id="photo" accept="image/*" name="photo" required>
            </div>
            <div class="mb-3">
                <label for="author" class="form-label">Author</label>
                <select class="form-control" id="author" name="author" required>
                    <?php
                    $authors = $conn->query("SELECT * FROM user WHERE RoleID = 1")->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($authors as $author) {
                        echo "<option value='{$author['UserID']}'>{$author['Username']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add News</button>
        </form>
      
    </div>
    

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  </body>
</html>
