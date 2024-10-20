<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Inscription</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="bg-image">
        <div class="container mt-5 pt-5">
            <div class="welcome-title text-center mb-5">
                <h1 class="fade-in">Inscription de l'entreprise</h1>
                <p class="fade-in delay-1">Complétez les informations ci-dessous pour vous inscrire sur notre plateforme.</p>
            </div>
            <div class="form-container fade-in delay-2">
                <h2 class="text-center mb-4">Inscription</h2>
                <form id="inscriptionForm" action="" method="POST">
                    <div class="form-group">
                        <label for="companyName">Nom de l'entreprise</label>
                        <input type="text" class="form-control" id="companyName" name="companyName" placeholder="Entrez le nom de votre entreprise" required>
                    </div>
                    <div class="form-group">
                        <label for="contactDetails">Coordonnées de contact</label>
                        <input type="text" class="form-control" id="contactDetails" name="contactDetails" placeholder="Entrez vos coordonnées de contact" required>
                    </div>
                    <div class="form-group">
                        <label for="numberOfEmployees">Nombre de personnel</label>
                        <input type="number" class="form-control" id="numberOfEmployees" name="numberOfEmployees" placeholder="Entrez le nombre de personnel" required>
                    </div>
                    <div class="form-group">
                        <label for="domain">Domaine</label>
                        <input type="text" class="form-control" id="domain" name="domain" placeholder="Entrez le domaine de votre entreprise" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Adresse e-mail</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Entrez votre adresse e-mail" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Entrez votre mot de passe" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">S'inscrire</button>
                </form>
                <div class="text-center mt-3">
                    <p>Vous avez déjà un compte ? <a href="login.php" class="btn btn-link">Se connecter</a></p>
                </div>

                <?php
                // Display any error messages
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Database connection
                    require_once 'config.php';

                    try {
                        // Connect to the database using PDO
                        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        // Collect data from the form
                        $companyName = $_POST['companyName'];
                        $contactDetails = $_POST['contactDetails'];
                        $numberOfEmployees = $_POST['numberOfEmployees'];
                        $domain = $_POST['domain'];
                        $email = $_POST['email'];
                        $hashedPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);

                        // Prepare SQL query to insert data
                        $sql = "INSERT INTO utilisateurs (company_name, contact_details, number_of_employees, domain, email, password) 
                                VALUES (:companyName, :contactDetails, :numberOfEmployees, :domain, :email, :password)";
                        $stmt = $conn->prepare($sql);

                        // Bind parameters
                        $stmt->bindParam(':companyName', $companyName);
                        $stmt->bindParam(':contactDetails', $contactDetails);
                        $stmt->bindParam(':numberOfEmployees', $numberOfEmployees);
                        $stmt->bindParam(':domain', $domain);
                        $stmt->bindParam(':email', $email);
                        $stmt->bindParam(':password', $hashedPassword);

                        // Execute the statement
                        $stmt->execute();

                        // Redirect with a success message
                        echo "<script>alert('Inscription réussie !'); window.location.href = 'main.php';</script>";
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
