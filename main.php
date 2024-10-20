<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
 
    header("Location: login.php");
    exit();
}

// Database connection
$conn = new mysqli('mysql-gestionservices.alwaysdata.net', '377253', 'assia08012004', 'gestionservices_gestion'); 


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Access denied. Please log in.");
}

// Get the current user's ID from the session
$currentUserId = $_SESSION['user_id'];

$accessRightsResult = $conn->query("SELECT section_name FROM access_rights WHERE user_id = $currentUserId");
$accessibleSections = [];

if ($accessRightsResult) {
    while ($row = $accessRightsResult->fetch_assoc()) {
        $accessibleSections[] = $row['section_name'];
    }
} else {
    echo "Error fetching access rights: " . $conn->error;
}

// Define all sections with links and descriptions
$allSections = [
    'Gestion des ressources humaines' => [
        'description' => 'Déclarations d’assurance, gestion des congés, pointages de présence.',
        'image' => 'https://img.freepik.com/premium-photo/man-jacket-dark-background-writes-text-virtual-screen-human-resource-management-hr_161452-959.jpg?size=626&ext=jpg&ga=GA1.1.1698318017.1722579199&semt=ais_hybrid',
        'link' => 'hr_management.php'
    ],
   'Gestion administrative' => [
    'description' => 'Gestion des documents administratifs, missions de travail.',
    'image' => 'https://img.freepik.com/free-photo/office-professional-laptop-cute-adult_1301-3077.jpg?ga=GA1.1.1698318017.1722579199&semt=ais_hybrid',
    'link' => 'planification.php'
   ],
    'Gestion des performances et du développement professionnel' => [
        'description' => 'Suivi des progrès professionnels, formation et développement.',
        'image' => 'https://img.freepik.com/free-photo/performance-skill-experience-accomplishment-concept_53876-134065.jpg?ga=GA1.1.1698318017.1722579199&semt=ais_hybrid',
        'link' => 'performance_management.php'
    ],
    'Gestion financière et des paies' => [
        'description' => 'Gestion des paies, suivi des dépenses.',
        'image' => 'https://img.freepik.com/free-photo/woman-working-with-finances-table-laptop-smartphone-money-notepad-clock_1268-17471.jpg?ga=GA1.1.1698318017.1722579199&semt=ais_hybrid',
        'link' => 'finance_management.php' 
    ],
    'Gestion des projets et des tâches' => [
        'description' => 'Planification des projets, gestion des missions.',
        'image' => 'https://img.freepik.com/free-vector/project-management-concept-flat-style_23-2147799813.jpg?ga=GA1.1.1698318017.1722579199&semt=ais_hybrid',
        'link' => 'project_management.php' 
    ],
    'Analyse et reporting' => [
        'description' => 'Tableaux de bord, rapports personnalisés.',
        'image' => 'https://img.freepik.com/free-photo/close-up-hands-with-financial-charts-business-meeting_1098-348.jpg?ga=GA1.1.1698318017.1722579199&semt=ais_hybrid',
        'link' => 'reporting_analysis.php' 
    ]
];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Principale</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <!-- Logo Section -->
    <header class="text-center py-3 bg-light">
        <div class="container">
            <img src="logo.jpg" alt="Logo" class="img-fluid" style="max-width: 150px;">
        </div>
    </header>
    <!-- Section Héro -->
    <section class="hero-section text-center py-5 bg-dark text-light">
        <div class="container">
            <h1>Bienvenue sur la Plateforme de Gestion</h1>
            <p>Votre centre principal pour gérer divers aspects de votre organisation.</p>
        </div>
    </section>

    <!-- Icon Bar -->
    <section class="icon-bar text-center py-3 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <a href="compte.php"><i class="fas fa-user fa-2x"></i><br>Compte</a>
                </div>
                <div class="col-md-4">
                    <a href="manage_roles.php"><i class="fas fa-cog fa-2x"></i><br>Gérer les Rôles</a>
                </div>
                <div class="col-md-4">
                    <a href="contact.php"><i class="fas fa-envelope fa-2x"></i><br>Contact</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Zone de Contenu Principal (Tableau de bord) -->
    <section class="main-content py-5">
        <div class="container">
            <div class="row">
                <?php foreach ($allSections as $sectionName => $sectionDetails): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <img src="<?php echo $sectionDetails['image']; ?>" alt="<?php echo $sectionName; ?>" class="img-fluid">
                            <h5 class="card-title"><?php echo $sectionName; ?></h5>
                            <p class="card-text"><?php echo $sectionDetails['description']; ?></p>
                            
                            <?php if (in_array($sectionName, $accessibleSections)): ?>
                            <a href="<?php echo $sectionDetails['link']; ?>" class="btn btn-primary">Voir les détails</a>
                            <?php else: ?>
                            <button class="btn btn-secondary" disabled>Accès refusé</button>
                            <p class="text-danger">Vous n'avez pas accès à cette section.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

</body>
</html>
