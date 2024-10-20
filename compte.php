<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once 'config.php';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve user information from the database
    $userId = $_SESSION['user_id'];
    $sql = "SELECT * FROM utilisateurs WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $userId);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "Utilisateur non trouvé.";
        exit();
    }

} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Compte</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-color: #f9f9f9;
            font-family: 'Poppins', sans-serif;
            color: #4a4a4a; /* Light grey for text */
        }
        .container {
            max-width: 800px;
            margin-top: 50px;
            margin-bottom: 50px;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        .card-header {
            background: linear-gradient(135deg, #6a11cb, #2575fc); /* Nice gradient */
            color: #ffffff; /* White text */
            padding: 25px;
            text-align: center;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
        .card-header h3 {
            margin: 0;
            font-weight: 600;
            font-size: 1.5rem;
        }
        .card-body {
            padding: 40px;
        }
        .card-body p {
            font-size: 1.1rem;
            margin-bottom: 15px;
            color: #6c757d; /* Muted text for details */
        }
        .card-body strong {
            color: #343a40; /* Darker for important labels */
        }
        .card-footer {
            background-color: #f1f3f5; /* Light background */
            padding: 20px;
            text-align: center;
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
        }
        .btn-custom {
            background-color: #2575fc;
            color: #fff;
            padding: 12px 30px;
            border-radius: 50px;
            transition: background-color 0.3s;
            font-weight: 500;
        }
        .btn-custom:hover {
            background-color: #1c61d6;
        }
        .btn-danger {
            background-color: #e63946; /* Bright red */
            border-radius: 50px;
        }
        .btn-danger:hover {
            background-color: #d62839;
        }
        .btn-warning {
            background-color: #ffba08; /* Bright yellow */
            border-radius: 50px;
        }
        .btn-warning:hover {
            background-color: #e3a007;
        }
        @media (max-width: 768px) {
            .card-body {
                padding: 20px;
            }
            .card {
                margin: 10px;
            }
        }
    </style>
</head>
<body>

<section class="container">
    <h1 class="text-center mb-4" style="color: #4a4a4a;">Mon Compte</h1>
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3>Informations de l'Entreprise</h3>
                </div>
                <div class="card-body">
                    <p><strong>Nom de l'entreprise :</strong> <?php echo htmlspecialchars($user['company_name']); ?></p>
                    <p><strong>Coordonnées de contact :</strong> <?php echo htmlspecialchars($user['contact_details']); ?></p>
                    <p><strong>Nombre de personnel :</strong> <?php echo htmlspecialchars($user['number_of_employees']); ?></p>
                    <p><strong>Domaine :</strong> <?php echo htmlspecialchars($user['domain']); ?></p>
                    <p><strong>Email :</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                </div>
                <div class="card-footer">
                    <a href="logout.php" class="btn btn-danger btn-custom">Déconnexion</a>
                    <a href="delete_account.php" class="btn btn-warning btn-custom">Supprimer le compte</a>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
