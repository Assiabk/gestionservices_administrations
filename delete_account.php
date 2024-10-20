<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Database connection
require_once 'config.php';   
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Delete user account from database
    $userId = $_SESSION['user_id'];
    $sql = "DELETE FROM utilisateurs WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $userId);
    $stmt->execute();

    // Destroy session
    session_destroy();

    header('Location: login.php');
    exit();

} catch (PDOException $e) {
    echo "Erreur de suppression du compte : " . $e->getMessage();
}