<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Connexion</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="bg-image">
        <div class="container mt-5 pt-5">
            <div class="welcome-title text-center mb-5">
                <h1 class="fade-in">Connexion</h1>
                <p class="fade-in delay-1">Veuillez entrer vos identifiants pour vous connecter.</p>
            </div>
            <div class="form-container fade-in delay-2">
                <h2 class="text-center mb-4">Connexion</h2>
                <form id="loginForm" action="" method="POST">
                    <div class="form-group">
                        <label for="email">Adresse e-mail</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Entrez votre adresse e-mail" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Entrez votre mot de passe" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
                </form>
                <div class="text-center mt-3">
                    <p>Vous n'avez pas encore de compte ? <a href="inscription.php" class="btn btn-link">S'inscrire</a></p>
                </div>

                <?php
                // Display any error messages
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    require_once 'config.php';

                    try {
                        // Connect to the database using PDO
                        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        // Collect data from the form
                        $email = $_POST['email'];
                        $enteredPassword = $_POST['password'];

                        // Prepare SQL query to select user
                        $sql = "SELECT * FROM utilisateurs WHERE email = :email";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':email', $email);
                        $stmt->execute();

                        // Fetch the user record
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);

                        // Check if user exists and verify password
                        if ($user && password_verify($enteredPassword, $user['password'])) {
                            // Start session and store user data
                            session_start();
                            $_SESSION['user_id'] = $user['id']; // Assuming 'id' is the primary key
                            $_SESSION['user_email'] = $user['email'];

                            // Redirect to main page
                            echo "<script>alert('Connexion réussie !'); window.location.href = 'main.php';</script>";
                        } else {
                            // Invalid credentials
                            echo "<div class='alert alert-danger mt-3'>Erreur : Identifiants invalides.</div>";
                        }
                    } catch (PDOException $e) {
                        // Display any error messages for debugging
                        echo "<div class='alert alert-danger mt-3'>Erreur : " . htmlspecialchars($e->getMessage()) . "</div>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
