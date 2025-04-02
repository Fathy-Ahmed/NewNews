<?php
include 'db.php';

if (isset($_GET['id'])) {
    $articleID = $_GET['id'];

    // Delete the article from the database
    $deleteQuery = "DELETE FROM article WHERE ArticleID = :articleID";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bindParam(':articleID', $articleID);
    $deleteStmt->execute();

    // Redirect to the manage news page after deletion
    header("Location: manage_news.php");
    exit();
} else {
    // Redirect if no article ID is specified
    header("Location: manage_news.php");
    exit();
}
?>
