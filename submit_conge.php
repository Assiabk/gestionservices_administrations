<?php
require 'vendor/autoload.php'; 

use Dompdf\Dompdf;
use Dompdf\Options;

session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once'config.php';

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
    
    // Get the company name from the user info
    $companyName = htmlspecialchars($user['company_name']);

} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}

// Initialize Dompdf
$options = new Options();
$options->set('defaultFont', 'Helvetica');
$dompdf = new Dompdf($options);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $nomSalarie = htmlspecialchars($_POST['nom_salarie']);
    $prenomSalarie = htmlspecialchars($_POST['prenom_salarie']);
    $poste = htmlspecialchars($_POST['fonction_salarie']);
    $debutConge = htmlspecialchars($_POST['debut_conge']);
    $motifConge = htmlspecialchars($_POST['motif_conge']);
    $lieu = "Votre Ville";  
    $dateAujourdHui = date('d/m/Y');

    // HTML content for the PDF
    $html = "
    <style>
        body {
            font-family: Helvetica, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #007BFF;
        }
        p {
            line-height: 1.5;
        }
        .signature {
            margin-top: 50px;
            border-top: 1px solid #000;
            width: 300px;
            text-align: center;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
    <body>
        <h1>Attestation de Congé de Maladie</h1>
        <p>Nous, soussignés, déclarons par la présente que le salarié nommé <strong>$nomSalarie</strong>, prénom <strong>$prenomSalarie</strong>, occupant le poste de <strong>$poste</strong> au sein de notre entreprise <strong>$companyName</strong>, est en congé de maladie à compter du <strong>$debutConge</strong>.</p>
        <p>Le congé de maladie est motivé par <strong>$motifConge</strong>. Un certificat médical attestant de l'incapacité de travail du salarié est joint à cette déclaration.</p>
        <p>Nous nous engageons à respecter les dispositions légales en vigueur concernant la gestion des congés de maladie et à assurer le suivi administratif nécessaire.</p>
        <p>Fait à <strong>$lieu</strong>, le <strong>$dateAujourdHui</strong>.</p>
        <div class='signature'>
            Signature de l'employeur ou du représentant de l'entreprise : <strong>[Nom et signature]</strong>
        </div>
        <p>Merci de contacter notre service des ressources humaines pour toute question ou information complémentaire.</p>
    </body>
    ";

    // Load HTML content into Dompdf
    $dompdf->loadHtml($html);

    // Set paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // Render the HTML as PDF
    $dompdf->render();

    // Output the generated PDF to browser
    $dompdf->stream('attestation_conge.pdf', ['Attachment' => true]); 
}
?>
