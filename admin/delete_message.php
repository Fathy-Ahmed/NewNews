<?php
session_start();
require '../connection.php';
$email = $conn->real_escape_string($_SESSION['username']);
$sql = "DELETE FROM message WHERE email_message='$email'"; 
$result = $conn->query($sql);
if ($result) {
} else {
    echo "Error deleting record: " . $conn->error;
}
session_unset();
session_destroy();
header('Location: manage_message.php'); 
?>