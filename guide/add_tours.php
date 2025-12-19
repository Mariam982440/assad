
<?php 
session_start();
require '../db.php'; 

    if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'guide') {
        die("Accès interdit : Vous n'êtes pas guide.");
    }
    // vérifier si le formulaire est soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $titre = mysqli_real_escape_string($conn, $_POST['titre']);
        $langue = mysqli_real_escape_string($conn, $_POST['langue']);
        $prix = floatval($_POST['prix']);
        $duree = intval($_POST['duree']);
        $capacite = intval($_POST['capacite']);
        $dateheure = $_POST['date'] . ' ' . $_POST['heure']; // concaténation Date + Heure
        $statut = 'plannifie';
        $id_utilisateur = $_SESSION['user_id'];

        
        $sql_tours = "INSERT INTO visite_guidee (titre, dateheure, langue, capacite_max, duree, prix, statut, id_utilisateur) 
                   VALUES ('$titre', '$dateheure', '$langue', $capacite, $duree, $prix, '$statut', $id_utilisateur)"; 
        
        if(mysqli_query($conn,$sql_tours)){
            // récupérer le id de la visite qu on vient de créer  
            mysqli_insert_id($conn);
        }
    }
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
        <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-blue-600">
            <h2 class="text-2xl font-bold text-gray-800 mb-6"><i class="fas fa-plus-circle mr-2"></i>Créer une Visite</h2>
            
            <!-- Le formulaire renvoie vers la même page (action vide) -->
            <form action="" method="POST" id="formVisite">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Colonne Gauche : Infos Visite -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 font-bold mb-1">Titre</label>
                            <input type="text" name="titre" required class="w-full border p-2 rounded" placeholder="Ex: Safari des Lions">
                        </div>

                        <div>
                            <label class="block text-gray-700 font-bold mb-1">Langue</label>
                            <select name="langue" class="w-full border p-2 rounded">
                                <option value="Français">Français</option>
                                <option value="Arabe">Arabe</option>
                                <option value="Anglais">Anglais</option>
                            </select>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-1/2">
                                <label class="block text-gray-700 font-bold mb-1">Date</label>
                                <input type="date" name="date" required class="w-full border p-2 rounded">
                            </div>
                            <div class="w-1/2">
                                <label class="block text-gray-700 font-bold mb-1">Heure</label>
                                <input type="time" name="heure" required class="w-full border p-2 rounded">
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-1/3">
                                <label class="block text-gray-700 font-bold mb-1">Prix (DH)</label>
                                <input type="number" name="prix" required class="w-full border p-2 rounded" placeholder="50">
                            </div>
                            <div class="w-1/3">
                                <label class="block text-gray-700 font-bold mb-1">Durée (min)</label>
                                <input type="number" name="duree" required class="w-full border p-2 rounded" placeholder="90">
                            </div>
                            <div class="w-1/3">
                                <label class="block text-gray-700 font-bold mb-1">Capacité</label>
                                <input type="number" name="capacite" required class="w-full border p-2 rounded" placeholder="20">
                            </div>
                        </div>
                    </div>

                    <!-- la gestion des etapes (ne peuvent pas etre envoyées seules) -->
                    <div class="bg-blue-50 p-4 rounded border border-blue-200">
                        <h3 class="font-bold text-blue-900 mb-3"><i class="fas fa-map-signs mr-2"></i>Parcours</h3>
                        
                        <!-- champs pour ajouter une étape  -->
                        <div class="space-y-2 mb-4 border-b pb-4 border-blue-200">
                            <div class="flex gap-2">
                                <input type="number" id="new_ordre" class="w-16 border p-2 rounded" value="1" placeholder="N°">
                                <input type="text" id="new_titre" class="flex-1 border p-2 rounded" placeholder="Titre étape (ex: Zone Lions)">
                            </div>
                            <div class="flex gap-2">
                                <input type="text" id="new_desc" class="flex-1 border p-2 rounded" placeholder="Description rapide...">
                                <button type="button" onclick="ajouterEtape()" class="bg-green-600 text-white px-4 rounded hover:bg-green-700 font-bold">+</button>
                            </div>
                        </div>

                        <!-- liste des étapes -->
                        <ul id="listeEtapes" class="space-y-2 text-sm">
                            <!-- les étapes ajoutées s'afficheront ici via JS -->
                            <li class="text-gray-500 italic text-center" id="emptyMsg">Aucune étape ajoutée</li>
                        </ul>

                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3 border-t pt-4">
                    <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-blue-700 shadow-lg">
                        <i class="fas fa-save mr-2"></i> Publier la visite
                    </button>
                </div>
            </form>
        </div>

        

            

            

        </div>
    </div>
</body>
</html>
<!-- script javaScript pour gerer les etapes -->
<script> 
    function ajouterEtape (){
        let ordre = document.getElementById('new_ordre');
        let titre = document.getElementById('new_titre');
        let desc = document.getElementById('new_desc');
    }
</script>