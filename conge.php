<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déclaration de congé de maladie</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.1/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <div class="max-w-4xl mx-auto mt-10 bg-white p-8 shadow-md rounded-lg">
        <h1 class="text-2xl font-bold mb-4 text-gray-700">Formulaire de Déclaration de Congé de Maladie</h1>

        <form action="submit_conge.php" method="POST" enctype="multipart/form-data" class="space-y-6">
            <!-- Employee Info -->
            <div>
                <label class="block text-gray-600 mb-2" for="nom_salarie">Nom du salarié :</label>
                <input type="text" id="nom_salarie" name="nom_salarie" class="w-full p-2 border border-gray-300 rounded" required>
            </div>

            <div>
                <label class="block text-gray-600 mb-2" for="prenom_salarie">Prénom du salarié :</label>
                <input type="text" id="prenom_salarie" name="prenom_salarie" class="w-full p-2 border border-gray-300 rounded" required>
            </div>

            <div>
                <label class="block text-gray-600 mb-2" for="fonction_salarie">Fonction du salarié :</label>
                <input type="text" id="fonction_salarie" name="fonction_salarie" class="w-full p-2 border border-gray-300 rounded" required>
            </div>

            <!-- Leave Info -->
            <div>
                <label class="block text-gray-600 mb-2" for="debut_conge">Date de début du congé :</label>
                <input type="date" id="debut_conge" name="debut_conge" class="w-full p-2 border border-gray-300 rounded" required>
            </div>

            <div>
                <label class="block text-gray-600 mb-2" for="fin_conge">Date de fin prévue du congé :</label>
                <input type="date" id="fin_conge" name="fin_conge" class="w-full p-2 border border-gray-300 rounded" required>
            </div>

            <div>
                <label class="block text-gray-600 mb-2" for="motif_conge">Motif du congé :</label>
                <textarea id="motif_conge" name="motif_conge" class="w-full p-2 border border-gray-300 rounded" required></textarea>
            </div>

            <div>
                <label class="block text-gray-600 mb-2" for="certificat_medical">Certificat médical joint :</label>
                <input type="file" id="certificat_medical" name="certificat_medical" class="w-full p-2 border border-gray-300 rounded" required>
            </div>

            <!-- Submission -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                    Soumettre
                </button>
            </div>
        </form>
    </div>

</body>
</html>
