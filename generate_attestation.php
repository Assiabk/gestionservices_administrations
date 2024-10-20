<?php
require 'vendor/autoload.php'; 

use Dompdf\Dompdf;
use Dompdf\Options;

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Get query parameters
    $employee_name = htmlspecialchars($_GET['employee_name']);
    $birth_date = htmlspecialchars($_GET['birth_date']);
    $position = htmlspecialchars($_GET['position']);
    $start_date = htmlspecialchars($_GET['start_date']);
    $end_date = isset($_GET['end_date']) ? htmlspecialchars($_GET['end_date']) : 'N/A';
    $manager_name = htmlspecialchars($_GET['manager_name']);
    $company_name = htmlspecialchars($_GET['company_name']);
    $company_address = htmlspecialchars($_GET['company_address']);
    $company_city = htmlspecialchars($_GET['company_city']);
    $company_registration = htmlspecialchars($_GET['company_registration']);

    // Configure Dompdf options
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);
    $options->set('isFontSubsettingEnabled', true);  
    $options->set('defaultFont', 'DejaVu Sans');  

    $dompdf = new Dompdf($options);

    // French content
    $html = "
    <html lang='fr'>
    <head>
        <meta charset='UTF-8'>
        <style>
            body { 
                font-family: 'DejaVu Sans', sans-serif; 
                text-align: left; 
            }
            h1, h2, p { margin: 0 0 10px 0; }
            .container { margin: 0 auto; padding: 20px; }
            .header { text-align: center; }
            .signature { margin-top: 50px; }
            .footer { margin-top: 40px; text-align: center; font-size: 12px; color: grey; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>République Algérienne Démocratique et Populaire</h1>
                <p>$company_name</p>
                <p>Adresse: $company_address, $company_city</p>
            </div>
            <h2>Attestation de Travail</h2>
            <p>Je soussigné(e) $manager_name, gérant(e) de la société $company_name située à $company_address, portant le numéro de registre de commerce $company_registration.</p>
            <p>Certifie que Mme $employee_name, né(e) le $birth_date à $company_city, travaille dans mon entreprise depuis le $start_date à ce jour en tant que $position.</p>";

    if ($end_date != 'N/A') {
        $html .= "<p>Date de fin de travail: $end_date</p>";
    }


    $html .= "
            <p>Cette attestation est délivrée pour être produite en tant que de besoin, dans les limites prévues par la loi.</p>
            <div class='signature'>
                <p>Fait à $company_city le " . date("Y-m-d") . "</p>
                <p>Le Gérant: $manager_name</p>
            </div>
        </div>
    </body>
    </html>";

    // Load HTML into Dompdf
    $dompdf->loadHtml($html);

    // Set paper size and orientation
    $dompdf->setPaper('A4', 'portrait');

    // Render the PDF
    $dompdf->render();

    // Output the generated PDF for download
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="attestation_' . $employee_name . '.pdf"');
    echo $dompdf->output();
}
