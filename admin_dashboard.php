<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Admin Dashboard - Liste des Utilisateurs</h1>

        <!-- User List Table -->
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nom de l'entreprise</th>
                    <th>Coordonnées</th>
                    <th>Nombre de Personnel</th>
                    <th>Domaine</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
require_once'config.php';

                try {
                    // Connect to the database using PDO
                    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Fetch all users from the 'utilisateurs' table
                    $sql = "SELECT * FROM utilisateurs";
                    $stmt = $conn->query($sql);

                    // Loop through and display user data
                    while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                                <td>{$user['id']}</td>
                                <td>{$user['company_name']}</td>
                                <td>{$user['contact_details']}</td>
                                <td>{$user['number_of_employees']}</td>
                                <td>{$user['domain']}</td>
                                <td>{$user['email']}</td>
                                <td>
                                    <a href='edit_user.php?id={$user['id']}' class='btn btn-warning btn-sm'>Modifier</a>
                                    <a href='delete_user.php?id={$user['id']}' class='btn btn-danger btn-sm' 
                                    onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cet utilisateur ?\");'>Supprimer</a>
                                </td>
                              </tr>";
                    }
                } catch (PDOException $e) {
                    echo "<div class='alert alert-danger'>Erreur de connexion : " . htmlspecialchars($e->getMessage()) . "</div>";
                }
                ?>
            </tbody>
        </table>

        <h2 class="mt-5">Gérer les Accès des Utilisateurs</h2>
        <form method="POST" action="manage_access.php" class="mb-4">
            <div class="form-group">
                <label for="user_id">Sélectionner un Utilisateur :</label>
                <select name="user_id" class="form-control" required>
                    <?php
                    // Fetch users again for access management
                    $stmt = $conn->query($sql);
                    while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$user['id']}'>{$user['company_name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="section_name">Sélectionner une Section :</label>
                <select name="section_name" class="form-control" required>
                    <?php
                    // Define sections names respecting the original names
                    $allSections = [
                        'Gestion des ressources humaines' => 'Gestion des ressources humaines',
                        'Gestion administrative' => 'Gestion administrative',
                        'Gestion des performances et du développement professionnel' => 'Gestion des performances et du développement professionnel',
                        'Gestion financière et des paies' => 'Gestion financière et des paies',
                        'Gestion des projets et des tâches' => 'Gestion des projets et des tâches',
                        'Analyse et reporting' => 'Analyse et reporting',
                    ];

                    // Populate sections in the dropdown
                    foreach ($allSections as $section) {
                        echo "<option value='$section'>$section</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit" name="grant_access" class="btn btn-success">Accorder l'Accès</button>
            <button type="submit" name="revoke_access" class="btn btn-danger">Révoquer l'Accès</button>
        </form>
        
        <!-- Message Display -->
        <?php if (isset($_GET['message'])): ?>
            <div class='alert alert-info'><?php echo htmlspecialchars($_GET['message']); ?></div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
