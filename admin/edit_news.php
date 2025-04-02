<?php
include 'db.php';
// $connnnn=mysqli_connect($host,
//                           $user,
//                           $pass,
//                           $db);
// if (isset($_GET['id'])) {
//     $articleID = $_GET['id'];

//     // Fetch the article from the database
//     $query = "SELECT * FROM article WHERE ArticleID = :articleID";
//     $stmt = $conn->prepare($query);
//     $stmt->bindParam(':articleID', $articleID);
//     $stmt->execute();
//     $article = $stmt->fetch(PDO::FETCH_ASSOC);

//     if (!$article) {
//         // Redirect if article not found
//         header("Location: manage_news.php");
//         exit();
//     }

//     // Handle form submission
//     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//         $title = $_POST['title'];
//         $content = $_POST['content'];
//         $category = $_POST['category'];
//         $status = $_POST['status'];
//         $img = $_POST['Image'];
//         $categoryQuery = mysqli_query($connnnn,"select Name from category where CategoryID=$category");
//         $rrrow = mysqli_fetch_assoc($categoryQuery);
//         if(isset($_FILES['photo'])){
//             if($_FILES['photo']['error']==UPLOAD_ERR_OK){
//                 $extention=explode('.',$_FILES['photo']['name']);
//                 $new_name=time().'.'.$extention[count($extention)-1];
//                 $upload_dir = "../img/news/" . $rrrow['Name'] . "/";
    
//                 if (!is_dir($upload_dir)) {
//                     mkdir($upload_dir, 0777, true); // Create the directory if it doesn't exist
//                 }
//                 $destination = $upload_dir . $new_name;
//                 $trimmed_path = ltrim($destination, '.');
//                 $trimmed_path = ltrim($trimmed_path, '/');
//                 if (move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
//                     echo "File uploaded successfully to: $destination";
//                 } else {
//                     echo "Failed to upload file.";
//                 }
//             }else {
//                 echo "Error in file upload: " . $_FILES['photo']['error'];
//             }
//         }
//         // Update the article in the database
//         $updateQuery = "UPDATE article SET Title = :title, Content = :content, CategoryID = :category, Status = :status , Image = :image WHERE ArticleID = :articleID";
//         $updateStmt = $conn->prepare($updateQuery);
//         $updateStmt->bindParam(':title', $title);
//         $updateStmt->bindParam(':content', $content);
//         $updateStmt->bindParam(':category', $category);
//         $updateStmt->bindParam(':status', $status);
//         $updateStmt->bindParam(':articleID', $articleID);
//         $updateStmt->bindParam(':image', $articleID);
//         $updateStmt->execute();

//         // Redirect back to the manage news page
//         header("Location: manage_news.php");
//         exit();
//     }
// } else {
//     // Redirect if no article ID is specified
//     header("Location: manage_news.php");
//     exit();
// }
?>
<?php
include 'db.php';
$connnnn = mysqli_connect($host, $user, $pass, $db);

if (isset($_GET['id'])) {
    $articleID = $_GET['id'];

    // Fetch the article from the database
    $query = "SELECT * FROM article WHERE ArticleID = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$articleID]);
    $article = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$article) {
        // Redirect if article not found
        header("Location: manage_news.php");
        exit();
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $category = $_POST['category'];
        $status = $_POST['status'];
        $oldImage = "../" . $article['Image']; // Old image path
        $newImagePath = $article['Image']; // Default to old image

        // Check if a new photo is uploaded
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $newName = time() . '.' . $extension;

            // Prepare upload directory
            $categoryQuery = mysqli_query($connnnn, "SELECT Name FROM category WHERE CategoryID = $category");
            $categoryRow = mysqli_fetch_assoc($categoryQuery);
            $uploadDir = "../img/news/" . $categoryRow['Name'] . "/";

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Create the directory if it doesn't exist
            }

            $destination = $uploadDir . $newName;
            $trimmedPath = ltrim($destination, './'); // Path to save in DB

            // Move the uploaded file
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
                // Delete the old photo
                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
                $newImagePath = $trimmedPath;
            } else {
                echo "Failed to upload new file.";
            }
        }

        // Update the article in the database
        $updateQuery = "UPDATE article SET Title = ?, Content = ?, CategoryID = ?, Status = ?, Image = ? WHERE ArticleID = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->execute([$title, $content, $category, $status, $newImagePath, $articleID]);

        // Redirect back to manage news page
        header("Location: manage_news.php");
        exit();
    }
} else {
    // Redirect if no article ID is specified
    header("Location: manage_news.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="../css/AdminPanel.css" />
  </head>
  <body>
    <div class="sidebar">
      <h2><a href="/newnews">New News</a></h2>
      <a href="AdminPanel.php">📊 Dashboard</a>
      <a href="manage_news.php">📰 Manage News</a>
      <a href="manage_user.php">👥 Manage Users</a>
      <a href="manage_message.php">✉️ User Messages</a>
      <div class="logout-btn">
        <a href="logout.php">🔓 Logout</a>
      </div>
    </div>

    <div class="main-content">
      <h1>📰 Manage News</h1>
      <h1 style="text-align: center; font-weight: bolder;">Edit News</h1>
      <!-- <div class="container mt-5"> -->
        <h1>Edit Article</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?= $article['Title'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content" rows="5" required><?= $article['Content'] ?></textarea>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" id="category" name="category" required>
                    <option value="1" <?= $article['CategoryID'] == 1 ? 'selected' : '' ?>>Sport</option>
                    <option value="2" <?= $article['CategoryID'] == 2 ? 'selected' : '' ?>>Business</option>
                    <option value="3" <?= $article['CategoryID'] == 3 ? 'selected' : '' ?>>Technology</option>
                    <option value="4" <?= $article['CategoryID'] == 4 ? 'selected' : '' ?>>Earth</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Photo</label>
                <input type="file" class="form-control" id="photo" accept="image/*" name="photo">
                <img id="photo-preview" src="../<?= $article['Image'] ?>" alt="Current Photo" style="max-width: 200px; margin-top: 10px;">
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <input type="text" class="form-control" id="status" name="status" value="<?= $article['Status'] ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Article</button>
        </form>
    <!-- </div> -->
      
    </div>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script>
        document.getElementById('photo').addEventListener('change', function (event) {
            const preview = document.getElementById('photo-preview');
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>

  </body>
</html>