<?php
$host = 'localhost';
$db = 'newsdb';
$user = 'root'; // قم بتغيير المستخدم إذا لزم الأمر
$pass = ''; // قم بتغيير كلمة المرور إذا لزم الأمر

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
