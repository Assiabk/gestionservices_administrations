<?php
session_start();

require_once 'config.php';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve form data
        $lastName = $_POST['lastName'];
        $firstName = $_POST['firstName'];
        $birthDateAndPlace = $_POST['birthDateAndPlace'];
        $idNumber = $_POST['idNumber'];
        $startDate = $_POST['startDate'];
        $jobPosition = $_POST['jobPosition'];

        // Handle file uploads
        $identityDocument = file_get_contents($_FILES['identityDocument']['tmp_name']);
        $birthCertificate = file_get_contents($_FILES['birthCertificate']['tmp_name']);
        $employmentCertificate = file_get_contents($_FILES['employmentCertificate']['tmp_name']);

        // Prepare SQL statement
        $sql = "INSERT INTO employee_declarations (last_name, first_name, birth_date_and_place, id_number, start_date, job_position, identity_document, birth_certificate, employment_certificate) 
                VALUES (:last_name, :first_name, :birth_date_and_place, :id_number, :start_date, :job_position, :identity_document, :birth_certificate, :employment_certificate)";
        $stmt = $conn->prepare($sql);
        
        // Bind parameters
        $stmt->bindParam(':last_name', $lastName);
        $stmt->bindParam(':first_name', $firstName);
        $stmt->bindParam(':birth_date_and_place', $birthDateAndPlace);
        $stmt->bindParam(':id_number', $idNumber);
        $stmt->bindParam(':start_date', $startDate);
        $stmt->bindParam(':job_position', $jobPosition);
        $stmt->bindParam(':identity_document', $identityDocument, PDO::PARAM_LOB);
        $stmt->bindParam(':birth_certificate', $birthCertificate, PDO::PARAM_LOB);
        $stmt->bindParam(':employment_certificate', $employmentCertificate, PDO::PARAM_LOB);

        // Execute the query
        $stmt->execute();
        
        // Redirect with success message
        header('Location: hr_management.php?success=true');
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
  <title>Gestion des ressources humaines</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="main.css">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8f9fa;
      color: #343a40;
    }

    header {
      background: linear-gradient(90deg, #6a11cb, #2575fc);
      padding: 20px;
      color: white;
      text-align: center;
    }

    header h1 {
      font-size: 2.5rem;
      margin: 0;
    }

    .breadcrumb {
      background: transparent;
      margin-bottom: 20px;
    }

    .breadcrumb a {
      color: #ffffff;
      text-decoration: none;
    }

    .breadcrumb a:hover {
      text-decoration: underline;
    }

    .breadcrumb-item.active {
      color: #ffc107;
    }

    section {
      background-color: white;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 30px;
      margin-bottom: 30px;
      transition: background-color 0.3s ease;
    }

    section:hover {
      background-color: #f9f9f9;
    }

    section h2 {
      font-size: 1.75rem;
      color: #007bff;
      margin-bottom: 15px;
    }

    section p {
      font-size: 1rem;
      line-height: 1.6;
    }

    .btn-declare {
      margin-top: 20px;
      font-size: 1rem;
      color: #fff;
      background-color: #28a745;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }

    .btn-declare:hover {
      background-color: #218838;
    }

    .btn-declare:focus {
      outline: none;
      box-shadow: 0 0 0 0.2rem rgba(72, 180, 97, 0.5);
    }

    .alert-success {
      background-color: #d4edda;
      color: #155724;
      border-color: #c3e6cb;
    }

    .alert-success .alert-heading {
      color: #155724;
    }
  </style>
</head>
<body>

  <header>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb justify-content-center">
        <li class="breadcrumb-item"><a href="main.php">Tableau de bord</a></li>
        <li class="breadcrumb-item active" aria-current="page">Gestion des ressources humaines</li>
      </ol>
    </nav>
    <h1>Gestion des ressources humaines</h1>
  </header>
  <section class="container py-4">
    <h2>Déclarations d'assurance</h2>
    <p>Gérez toutes vos déclarations d'assurance.</p>
    <button class="btn-declare" data-toggle="modal" data-target="#declarationAssuranceModal">Cliquez ici</button>
  
    <!-- Modal for declaration of assurance -->
    <div class="modal fade" id="declarationAssuranceModal" tabindex="-1" role="dialog" aria-labelledby="declarationAssuranceModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="declarationAssuranceModalLabel">Déclaration d'assurance</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="employeeDeclarationForm" action="hr_management.php" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <label for="lastName">Nom</label>
                <input type="text" class="form-control" id="lastName" name="lastName" required>
              </div>
              <div class="form-group">
                <label for="firstName">Prénom</label>
                <input type="text" class="form-control" id="firstName" name="firstName" required>
              </div>
              <div class="form-group">
                <label for="birthDateAndPlace">Date et lieu de naissance</label>
                <input type="text" class="form-control" id="birthDateAndPlace" name="birthDateAndPlace" placeholder="Date et lieu" required>
              </div>
              <div class="form-group">
                <label for="idNumber">Numéro de pièce d'identité</label>
                <input type="text" class="form-control" id="idNumber" name="idNumber" required>
              </div>
              <div class="form-group">
                <label for="startDate">Date de début de travail</label>
                <input type="date" class="form-control" id="startDate" name="startDate" required>
              </div>
              <div class="form-group">
                <label for="jobPosition">Poste occupé</label>
                <input type="text" class="form-control" id="jobPosition" name="jobPosition" required>
              </div>
              <div class="form-group">
                <label for="identityDocument">Copie de pièce d'identité (PDF ou image)</label>
                <input type="file" class="form-control" id="identityDocument" name="identityDocument" accept=".pdf,.jpg,.jpeg,.png" required>
              </div>
              <div class="form-group">
                <label for="birthCertificate">Acte de naissance (PDF ou image)</label>
                <input type="file" class="form-control" id="birthCertificate" name="birthCertificate" accept=".pdf,.jpg,.jpeg,.png" required>
              </div>
              <div class="form-group">
                <label for="employmentCertificate">Attestation de travail (PDF ou image)</label>
                <input type="file" class="form-control" id="employmentCertificate" name="employmentCertificate" accept=".pdf,.jpg,.jpeg,.png" required>
              </div>
              <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <?php if (isset($_GET['success']) && $_GET['success'] == 'true'): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Succès!</strong> Les informations ont été enregistrées avec succès.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <?php endif; ?>
  </section>
  <section class="container py-4">
  <h2>Gestion des congés</h2>
  <p>Suivez et gérez les congés des employés.</p>
  <a href="conge.php">
    <button class="btn-declare">Cliquez ici</button>
  </a>
</section>

<section class="container py-4">
    <h2>Déclaration d'accident</h2>
    <p>Enregistrez et surveillez les déclarations d'accident.</p>
 
    <a href="accident.php">
    <button class="btn-declare">Cliquez ici</button>
  </a>
</section>


  <section class="container py-4">
    <h2>Pointages de présence</h2>
    <p>Enregistrez et surveillez les pointages de présence.</p>
    <button class="btn-declare">Cliquez ici</button>
  </section>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
