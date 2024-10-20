<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Déclaration d'Accident de Travail</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.1/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <div class="max-w-4xl mx-auto mt-10 bg-white p-8 shadow-md rounded-lg">
        <h1 class="text-2xl font-bold mb-4 text-gray-700">Formulaire de Déclaration d'Accident de Travail</h1>

        <form action="submit_accident.php" method="POST" enctype="multipart/form-data" class="space-y-6">
            <!-- Victim Info -->
            <div>
                <label class="block text-gray-600 mb-2" for="nom_victime">Nom du travailleur victime de l'accident :</label>
                <input type="text" id="nom_victime" name="nom_victime" class="w-full p-2 border border-gray-300 rounded" required>
            </div>

            <div>
                <label class="block text-gray-600 mb-2" for="prenom_victime">Prénom du travailleur victime de l'accident :</label>
                <input type="text" id="prenom_victime" name="prenom_victime" class="w-full p-2 border border-gray-300 rounded" required>
            </div>

            <!-- Accident Info -->
            <div>
                <label class="block text-gray-600 mb-2" for="date_accident">Date de l'accident de travail :</label>
                <input type="date" id="date_accident" name="date_accident" class="w-full p-2 border border-gray-300 rounded" required>
            </div>

            <div>
                <label class="block text-gray-600 mb-2" for="heure_accident">Heure de l'accident de travail :</label>
                <input type="time" id="heure_accident" name="heure_accident" class="w-full p-2 border border-gray-300 rounded" required>
            </div>

            <div>
                <label class="block text-gray-600 mb-2" for="lieu_accident">Lieu de l'accident de travail :</label>
                <input type="text" id="lieu_accident" name="lieu_accident" class="w-full p-2 border border-gray-300 rounded" required>
            </div>

            <div>
                <label class="block text-gray-600 mb-2" for="description_accident">Description de l'accident de travail :</label>
                <textarea id="description_accident" name="description_accident" class="w-full p-2 border border-gray-300 rounded" required></textarea>
            </div>

            <div>
                <label class="block text-gray-600 mb-2" for="dommages_materiels">Dommages matériels (le cas échéant) :</label>
                <textarea id="dommages_materiels" name="dommages_materiels" class="w-full p-2 border border-gray-300 rounded"></textarea>
            </div>

            <div>
                <label class="block text-gray-600 mb-2" for="temoins">Témoins de l'accident de travail (le cas échéant) :</label>
                <textarea id="temoins" name="temoins" class="w-full p-2 border border-gray-300 rounded"></textarea>
            </div>

            <div>
                <label class="block text-gray-600 mb-2" for="fichier_joint">Fichier à joindre :</label>
                <input type="file" id="fichier_joint" name="fichier_joint" class="w-full p-2 border border-gray-300 rounded" required>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                    Soumettre
                </button>
            </div>
        </form>
    </div>

</body>
</html>
