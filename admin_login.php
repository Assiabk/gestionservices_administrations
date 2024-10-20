<?php
session_start();

// Check if the admin is already logged in, redirect to the dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: admin_dashboard.php");
    exit();
}

require_once 'config.php';
try {
    // Connect to the database using PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . htmlspecialchars($e->getMessage()));
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputEmail = $_POST['email'] ?? '';
    $inputPassword = $_POST['password'] ?? '';

    // Prepare and execute query to find the admin by email
    $stmt = $conn->prepare("SELECT * FROM admins WHERE email = :email LIMIT 1");
    $stmt->bindParam(':email', $inputEmail, PDO::PARAM_STR);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if admin exists and verify password
    if ($admin && md5($inputPassword) === $admin['password']) {
        // Set session variable for logged-in admin
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_email'] = $admin['email'];

        // Redirect to the admin dashboard
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Email or password is incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sign In</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Admin Sign In</h2>
        <form method="POST" action="admin_login.php" class="mt-4">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe:</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
        </form>

        <?php if (isset($error)) : ?>
            <div class="alert alert-danger mt-3 text-center"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
