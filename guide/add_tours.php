
<?php 
session_start();
require '../db.php'; 

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'guide') {
    die("Accès interdit : Vous n'êtes pas administrateur.");
}

// $titre=$_POST['titre'];
// $langue=$_POST['langue'];
// $prix=$_POST['prix'];
// $duree=$_POST['duree'];
// $capacite=$_POST['capacite'];
// $dateheure = $_POST['date'] . ' ' . $_POST['heure'];
// $statut = 'plannifie';
// $id_utilisateur = $_SESSION['user_id'];


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Guide - Mes Visites</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">

    <div class="container mx-auto px-6 py-8">
        
        <!-- SECTION 1: FORMULAIRE DE CRÉATION -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-10 border-t-4 border-blue-600">
            <h2 class="text-2xl font-bold text-gray-800 mb-6"><i class="fas fa-plus-circle mr-2"></i>Créer une Visite</h2>
            
            <form action="process_guide.php" method="POST">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Infos de base -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Titre de la visite</label>
                        <input type="text" name="titre" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:border-blue-500" placeholder="Ex: Safari des Lions">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Langue</label>
                        <select name="langue" class="w-full border border-gray-300 p-2 rounded">
                            <option value="français">Français</option>
                            <option value="Arabe">Arabe</option>
                            <option value="Anglais">Anglais</option>
                        </select>
                    </div>

                    <div class="flex gap-4">
                        <div class="w-1/2">
                            <label class="block text-gray-700 font-bold mb-2">Date</label>
                            <input type="date" name="date" class="w-full border border-gray-300 p-2 rounded">
                        </div>
                        <div class="w-1/2">
                            <label class="block text-gray-700 font-bold mb-2">Heure Début</label>
                            <input type="time" name="heure" class="w-full border border-gray-300 p-2 rounded">
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="w-1/2">
                            <label class="block text-gray-700 font-bold mb-2">Prix (MAD)</label>
                            <input type="number" name="prix" class="w-full border border-gray-300 p-2 rounded" placeholder="50">
                        </div>
                        <div class="w-1/2">
                            <label class="block text-gray-700 font-bold mb-2">Durée</label>
                            <input type="number" name="duree" class="w-full border border-gray-300 p-2 rounded" placeholder="50">
                        </div>
                        <div class="w-1/2">
                            <label class="block text-gray-700 font-bold mb-2">Capacité Max</label>
                            <input type="number" name="capacite" class="w-full border border-gray-300 p-2 rounded" placeholder="20">
                        </div>
                    </div>

                    <!-- GESTION DES ÉTAPES (PARCOURS) -->
                    <div class="md:col-span-2 bg-blue-50 p-4 rounded border border-blue-200">
                        <h3 class="font-bold text-blue-900 mb-3"><i class="fas fa-map-signs mr-2"></i>Définir le Parcours (Étapes)</h3>
                        
                        <!-- Zone pour ajouter une étape -->
                        <div class="flex gap-2 mb-4">
                            <input type="text" placeholder="Titre de l'étape (ex: Zone Savane)" class="flex-1 border p-2 rounded">
                            <input type="number" placeholder="Ordre" class="w-20 border p-2 rounded" value="1">
                            <button type="button" class="bg-green-600 text-white px-4 rounded hover:bg-green-700">Ajouter</button>
                        </div>

                        <!-- Liste des étapes ajoutées (Aperçu) -->
                        <ul class="space-y-2">
                            <li class="bg-white p-2 rounded shadow-sm flex justify-between items-center border-l-4 border-green-500">
                                <span><span class="font-bold text-gray-500 mr-2">1.</span> Présentation Lions de l'Atlas</span>
                                <button class="text-red-500 text-sm hover:underline">Supprimer</button>
                            </li>
                            <li class="bg-white p-2 rounded shadow-sm flex justify-between items-center border-l-4 border-green-500">
                                <span><span class="font-bold text-gray-500 mr-2">2.</span> Nourrissage des Crocodiles</span>
                                <button class="text-red-500 text-sm hover:underline">Supprimer</button>
                            </li>
                        </ul>
                    </div>

                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="reset" class="bg-gray-300 text-gray-700 px-6 py-2 rounded font-bold hover:bg-gray-400">Annuler</button>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded font-bold hover:bg-blue-700">Enregistrer la visite</button>
                </div>
            </form>
        </div>

        

            

            

        </div>
    </div>
</body>
</html>