<?php 
session_start();
require '../db.php'; 

// 1. SÉCURITÉ
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'guide') {
    die("Accès interdit : Vous n'êtes pas guide.");
}

$message = "";

// 2. TRAITEMENT DU FORMULAIRE
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // A. Récupération des infos de la visite
    $titre = mysqli_real_escape_string($conn, $_POST['titre']);
    $langue = mysqli_real_escape_string($conn, $_POST['langue']);
    $prix = floatval($_POST['prix']);
    $duree = intval($_POST['duree']);
    $capacite = intval($_POST['capacite']);
    $dateheure = $_POST['date'] . ' ' . $_POST['heure']; // Concaténation Date + Heure
    $statut = 'plannifie';
    $id_utilisateur = $_SESSION['user_id'];

    // B. Insertion de la Visite
    $sql_visite = "INSERT INTO visite_guidee (titre, dateheure, langue, capacite_max, duree, prix, statut, id_utilisateur) 
                   VALUES ('$titre', '$dateheure', '$langue', $capacite, $duree, $prix, '$statut', $id_utilisateur)";

    if (mysqli_query($conn, $sql_visite)) {
        // C. On récupère l'ID de la visite qu'on vient de créer
        $id_visite_creee = mysqli_insert_id($conn);

        // D. Insertion des étapes (S'il y en a)
        if (isset($_POST['etapes_titre']) && is_array($_POST['etapes_titre'])) {
            
            // On boucle sur les tableaux envoyés par le formulaire
            for ($i = 0; $i < count($_POST['etapes_titre']); $i++) {
                $titre_etape = mysqli_real_escape_string($conn, $_POST['etapes_titre'][$i]);
                $desc_etape = mysqli_real_escape_string($conn, $_POST['etapes_desc'][$i]);
                $ordre = intval($_POST['etapes_ordre'][$i]);

                $sql_etape = "INSERT INTO etapesvisite (titreetape, descriptionetape, ordreetape, id_visite) 
                              VALUES ('$titre_etape', '$desc_etape', $ordre, $id_visite_creee)";
                mysqli_query($conn, $sql_etape);
            }
        }

        $message = "<div class='bg-green-100 text-green-700 p-4 rounded mb-6'>Visite créée avec succès avec ses étapes !</div>";
    } else {
        $message = "<div class='bg-red-100 text-red-700 p-4 rounded mb-6'>Erreur SQL : " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Guide - Créer Visite</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">

    <!-- NAVBAR SIMPLIFIÉE -->
    <nav class="bg-blue-900 text-white p-4 mb-6">
        <div class="container mx-auto flex justify-between">
            <span class="font-bold">Espace Guide</span>
            <a href="../asaad.php" class="text-sm hover:underline">Retour Accueil</a>
        </div>
    </nav>

    <div class="container mx-auto px-6 pb-12">
        
        <?= $message ?>

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

                    <!-- Colonne Droite : GESTION DES ÉTAPES (JS) -->
                    <div class="bg-blue-50 p-4 rounded border border-blue-200">
                        <h3 class="font-bold text-blue-900 mb-3"><i class="fas fa-map-signs mr-2"></i>Parcours</h3>
                        
                        <!-- Champs pour ajouter une étape (Non envoyés directement) -->
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

                        <!-- Liste visuelle des étapes -->
                        <ul id="listeEtapes" class="space-y-2 text-sm">
                            <!-- Les étapes s'afficheront ici via JS -->
                            <li class="text-gray-500 italic text-center" id="emptyMsg">Aucune étape ajoutée</li>
                        </ul>

                        <!-- CONTENEUR DES INPUTS CACHÉS (C'est ça qui est envoyé à PHP) -->
                        <div id="hiddenInputsContainer"></div>

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

    <!-- JAVASCRIPT POUR GÉRER LES ÉTAPES -->
    <script>
        function ajouterEtape() {
            // 1. Récupérer les valeurs
            let ordre = document.getElementById('new_ordre').value;
            let titre = document.getElementById('new_titre').value;
            let desc = document.getElementById('new_desc').value;

            if(titre === "") {
                alert("Veuillez mettre un titre à l'étape");
                return;
            }

            // 2. Masquer le message "vide"
            document.getElementById('emptyMsg').style.display = 'none';

            // 3. Créer l'élément visuel (LI)
            let ul = document.getElementById('listeEtapes');
            let li = document.createElement('li');
            li.className = "bg-white p-2 rounded shadow-sm border-l-4 border-green-500 flex justify-between items-center";
            li.innerHTML = `
                <div>
                    <span class="font-bold text-gray-700 mr-2">${ordre}.</span>
                    <span class="font-bold">${titre}</span>
                    <p class="text-gray-500 text-xs">${desc}</p>
                </div>
            `;
            ul.appendChild(li);

            // 4. Créer les INPUTS CACHÉS pour PHP (C'est le plus important !)
            let container = document.getElementById('hiddenInputsContainer');
            
            // On utilise la notation tableau [] pour que PHP récupère un array
            container.innerHTML += `
                <input type="hidden" name="etapes_ordre[]" value="${ordre}">
                <input type="hidden" name="etapes_titre[]" value="${titre}">
                <input type="hidden" name="etapes_desc[]" value="${desc}">
            `;

            // 5. Reset des champs et incrémenter l'ordre
            document.getElementById('new_titre').value = "";
            document.getElementById('new_desc').value = "";
            document.getElementById('new_ordre').value = parseInt(ordre) + 1;
        }
    </script>
</body>
</html>