<?php
session_start();

require_once 'config.php';

try {
    // Connect to the database using PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $userId = $_POST['user_id'];
        $sectionName = $_POST['section_name'];

        // Check if access should be granted
        if (isset($_POST['grant_access'])) {
            // Check if the user already has access to the section
            $query = "SELECT * FROM access_rights WHERE user_id = :user_id AND section_name = :section_name";
            $stmt = $conn->prepare($query);
            $stmt->execute(['user_id' => $userId, 'section_name' => $sectionName]);

            if ($stmt->rowCount() > 0) {
                // User already has access
                header("Location: admin_dashboard.php?message=Cet utilisateur a déjà accès à cette section.");
            } else {
                // Grant access
                $query = "INSERT INTO access_rights (user_id, section_name) VALUES (:user_id, :section_name)";
                $stmt = $conn->prepare($query);
                $stmt->execute(['user_id' => $userId, 'section_name' => $sectionName]);
                header("Location: admin_dashboard.php?message=Accès accordé avec succès.");
            }
        }

        // Check if access should be revoked
        if (isset($_POST['revoke_access'])) {
            $query = "DELETE FROM access_rights WHERE user_id = :user_id AND section_name = :section_name";
            $stmt = $conn->prepare($query);
            $stmt->execute(['user_id' => $userId, 'section_name' => $sectionName]);
            header("Location: admin_dashboard.php?message=Accès révoqué avec succès.");
        }
    }
} catch (PDOException $e) {
    header("Location: admin_dashboard.php?message=Erreur: " . htmlspecialchars($e->getMessage()));
    exit();
}
