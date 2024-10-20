<?php
require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Initialize Dompdf
$options = new Options();
$options->set('defaultFont', 'Helvetica');
$dompdf = new Dompdf($options);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $nomVictime = htmlspecialchars($_POST['nom_victime']);
    $prenomVictime = htmlspecialchars($_POST['prenom_victime']);
    $dateAccident = htmlspecialchars($_POST['date_accident']);
    $heureAccident = htmlspecialchars($_POST['heure_accident']);
    $lieuAccident = htmlspecialchars($_POST['lieu_accident']);
    $descriptionAccident = htmlspecialchars($_POST['description_accident']);
    $dommagesMateriels = htmlspecialchars($_POST['dommages_materiels']);
    $temoins = htmlspecialchars($_POST['temoins']);
    $dateFormulaire = date('d/m/Y');
    
    // Create the HTML content for the PDF
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
        <h1>Formulaire de Déclaration d'Accident de Travail</h1>

        <p>Nous, soussignés, déclarons par la présente que le salarié nommé <strong>$nomVictime</strong>, prénom <strong>$prenomVictime</strong>, a été victime d'un accident du travail le <strong>$dateAccident</strong> à <strong>$lieuAccident</strong>. L'accident s'est produit lors de l'exécution de ses fonctions.</p>
        
        <p>Nous avons été informés de l'accident et avons pris les mesures nécessaires pour assurer sa prise en charge médicale. Nous nous engageons à collaborer activement avec les organismes compétents pour établir le dossier relatif à cet accident du travail.</p>
        
        <p>Nous nous tenons à disposition pour fournir tous les documents et informations nécessaires à la gestion de ce dossier.</p>
        
        <p>Fait à <strong>[Ville]</strong>, le <strong>$dateFormulaire</strong></p>
        
        <div class='signature'>
            Signature de l'employeur ou du représentant de l'entreprise : <strong>[Nom et signature]</strong>
        </div>
    </body>
    ";

    // Load HTML into Dompdf
    $dompdf->loadHtml($html);

    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // Render the PDF
    $dompdf->render();

    // Output the generated PDF to browser (force download)
    $dompdf->stream("declaration_accident_travail.pdf", ["Attachment" => 1]);
}
?>
