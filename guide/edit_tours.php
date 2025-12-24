<?php
session_start();
require '../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'guide') {
    die("Accès interdit.");
}

$id_guide = $_SESSION['user_id'];
$message = "";

// vérifier l'id de la visite 
if (!isset($_GET['id'])) {
    header("Location: guide_tours.php");
    exit();
}

$id_visite = intval($_GET['id']);

// vérifier que la visite appartient bien à ce guide
$sql_check = "SELECT * FROM visite_guidee WHERE id = $id_visite AND id_utilisateur = $id_guide";
$result_check = mysqli_query($conn, $sql_check);
$visite = mysqli_fetch_assoc($result_check);

if (!$visite) {
    die("Visite introuvable ou vous n'avez pas les droits pour la modifier.");
}

// traitement de la modification
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // récupération des données
    $titre = mysqli_real_escape_string($conn, $_POST['titre']);
    $langue = mysqli_real_escape_string($conn, $_POST['langue']);
    $prix = floatval($_POST['prix']);
    $duree = intval($_POST['duree']);
    $capacite = intval($_POST['capacite']);
    $dateheure = $_POST['date'] . ' ' . $_POST['heure'];

    // mise à jour de la table visite_guidee
    $sql_update = "UPDATE visite_guidee SET 
                   titre = '$titre', 
                   dateheure = '$dateheure', 
                   langue = '$langue', 
                   capacite_max = $capacite, 
                   duree = $duree, 
                   prix = $prix 
                   WHERE id = $id_visite";

    if (mysqli_query($conn, $sql_update)) {
        
        // gestion des étapes : supprimer les anciennes et créer les nouvelles
        mysqli_query($conn, "DELETE FROM etapesvisite WHERE id_visite = $id_visite");

        if (isset($_POST['etapes_titre']) && is_array($_POST['etapes_titre'])) {
            for ($i = 0; $i < count($_POST['etapes_titre']); $i++) {
                $titre_etape = mysqli_real_escape_string($conn, $_POST['etapes_titre'][$i]);
                $desc_etape = mysqli_real_escape_string($conn, $_POST['etapes_desc'][$i]);
                // On recalcule l'ordre proprement (1, 2, 3...)
                $ordre = $i + 1; 

                $sql_etape = "INSERT INTO etapesvisite (titreetape, descriptionetape, ordreetape, id_visite) 
                              VALUES ('$titre_etape', '$desc_etape', $ordre, $id_visite)";
                mysqli_query($conn, $sql_etape);
            }
        }

        $message = "<div class='bg-green-100 text-green-700 p-4 rounded mb-6'>Modifications enregistrées avec succès ! <a href='guide_tours.php' class='underline font-bold'>Retour</a></div>";
        
        // recharger les données pour l'affichage
        $result_check = mysqli_query($conn, $sql_check);
        $visite = mysqli_fetch_assoc($result_check);

    } else {
        $message = "<div class='bg-red-100 text-red-700 p-4 rounded mb-6'>Erreur SQL : " . mysqli_error($conn) . "</div>";
    }
}

// pré-remplir les étapes existantes
$sql_etapes = "SELECT * FROM etapesvisite WHERE id_visite = $id_visite ORDER BY ordreetape ASC";
$res_etapes = mysqli_query($conn, $sql_etapes);

// séparation Date et Heure pour les inputs HTML
$datetime = explode(' ', $visite['dateheure']);
$val_date = $datetime[0];
$val_heure = substr($datetime[1], 0, 5); // Garde HH:MM
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Visite</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .step-item:hover .btn-delete { display: block; }
    </style>
</head>
<body class="bg-gray-50">

    <nav class="bg-blue-900 text-white p-4 mb-6">
        <div class="container mx-auto flex justify-between">
            <span class="font-bold">Modification Visite #<?= $id_visite ?></span>
            <a href="guide_tours.php" class="text-sm hover:underline">Retour à la liste</a>
        </div>
    </nav>

    <div class="container mx-auto px-6 pb-12">
        
        <?= $message ?>

        <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-yellow-500">
            <h2 class="text-2xl font-bold text-gray-800 mb-6"><i class="fas fa-edit mr-2"></i>Modifier la visite</h2>
            
            <form action="" method="POST" id="formVisite">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Colonne Gauche : Infos Visite -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 font-bold mb-1">Titre</label>
                            <input type="text" name="titre" value="<?= htmlspecialchars($visite['titre']) ?>" required class="w-full border p-2 rounded">
                        </div>

                        <div>
                            <label class="block text-gray-700 font-bold mb-1">Langue</label>
                            <select name="langue" class="w-full border p-2 rounded">
                                <option <?= $visite['langue'] == 'Français' ? 'selected' : '' ?>>Français</option>
                                <option <?= $visite['langue'] == 'Arabe' ? 'selected' : '' ?>>Arabe</option>
                                <option <?= $visite['langue'] == 'Anglais' ? 'selected' : '' ?>>Anglais</option>
                            </select>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-1/2">
                                <label class="block text-gray-700 font-bold mb-1">Date</label>
                                <input type="date" name="date" value="<?= $val_date ?>" required class="w-full border p-2 rounded">
                            </div>
                            <div class="w-1/2">
                                <label class="block text-gray-700 font-bold mb-1">Heure</label>
                                <input type="time" name="heure" value="<?= $val_heure ?>" required class="w-full border p-2 rounded">
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-1/3">
                                <label class="block text-gray-700 font-bold mb-1">Prix (DH)</label>
                                <input type="number" name="prix" value="<?= $visite['prix'] ?>" required class="w-full border p-2 rounded">
                            </div>
                            <div class="w-1/3">
                                <label class="block text-gray-700 font-bold mb-1">Durée (min)</label>
                                <input type="number" name="duree" value="<?= $visite['duree'] ?>" required class="w-full border p-2 rounded">
                            </div>
                            <div class="w-1/3">
                                <label class="block text-gray-700 font-bold mb-1">Capacité</label>
                                <input type="number" name="capacite" value="<?= $visite['capacite_max'] ?>" required class="w-full border p-2 rounded">
                            </div>
                        </div>
                    </div>

                    <!-- Colonne Droite : ÉTAPES -->
                    <div class="bg-blue-50 p-4 rounded border border-blue-200">
                        <h3 class="font-bold text-blue-900 mb-3"><i class="fas fa-map-signs mr-2"></i>Parcours</h3>
                        
                        <!-- Formulaire Ajout Rapide -->
                        <div class="space-y-2 mb-4 border-b pb-4 border-blue-200">
                            <div class="flex gap-2">
                                <input type="text" id="new_titre" class="flex-1 border p-2 rounded" placeholder="Titre étape">
                            </div>
                            <div class="flex gap-2">
                                <input type="text" id="new_desc" class="flex-1 border p-2 rounded" placeholder="Description...">
                                <button type="button" onclick="ajouterEtape()" class="bg-green-600 text-white px-4 rounded hover:bg-green-700 font-bold">+</button>
                            </div>
                        </div>

                        <!-- CONTENEUR DES ÉTAPES (VISUEL + HIDDEN INPUTS) -->
                        <div id="containerEtapes" class="space-y-2">
                            
                            <!-- BOUCLE PHP POUR AFFICHER LES ÉTAPES EXISTANTES -->
                            <?php 
                            $counter = 0;
                            while($etape = mysqli_fetch_assoc($res_etapes)): 
                                $counter++;
                            ?>
                                <div class="step-item bg-white p-2 rounded shadow-sm border-l-4 border-blue-500 flex justify-between items-center group">
                                    <div class="w-full">
                                        <div class="flex justify-between">
                                            <span class="font-bold text-gray-800"><?= $counter ?>. <?= htmlspecialchars($etape['titreetape']) ?></span>
                                            <button type="button" onclick="supprimerEtape(this)" class="text-red-500 text-sm hover:text-red-700"><i class="fas fa-trash"></i></button>
                                        </div>
                                        <p class="text-xs text-gray-500"><?= htmlspecialchars($etape['descriptionetape']) ?></p>
                                        
                                        <!-- INPUTS CACHÉS INDISPENSABLES POUR LE POST -->
                                        <input type="hidden" name="etapes_titre[]" value="<?= htmlspecialchars($etape['titreetape']) ?>">
                                        <input type="hidden" name="etapes_desc[]" value="<?= htmlspecialchars($etape['descriptionetape']) ?>">
                                    </div>
                                </div>
                            <?php endwhile; ?>

                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3 border-t pt-4">
                    <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-blue-700 shadow-lg">
                        <i class="fas fa-save mr-2"></i> Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script>
        // Fonction pour supprimer visuellement et logiquement une étape
        function supprimerEtape(btn) {
            if(confirm('Supprimer cette étape ?')) {
                // Le bouton est dans une div, qui est dans une div "step-item"
                // On remonte au parent principal pour le supprimer
                btn.closest('.step-item').remove();
            }
        }

        function ajouterEtape() {
            let titre = document.getElementById('new_titre').value;
            let desc = document.getElementById('new_desc').value;

            if(titre.trim() === "") {
                alert("Titre obligatoire");
                return;
            }

            let container = document.getElementById('containerEtapes');
            // On compte combien d'étapes existent déjà pour le numéro
            let count = container.children.length + 1;

            let div = document.createElement('div');
            div.className = "step-item bg-white p-2 rounded shadow-sm border-l-4 border-green-500 flex justify-between items-center group";
            
            // On injecte le HTML avec les Hidden Inputs
            div.innerHTML = `
                <div class="w-full">
                    <div class="flex justify-between">
                        <span class="font-bold text-gray-800">${count}. ${titre} (Nouveau)</span>
                        <button type="button" onclick="supprimerEtape(this)" class="text-red-500 text-sm hover:text-red-700"><i class="fas fa-trash"></i></button>
                    </div>
                    <p class="text-xs text-gray-500">${desc}</p>
                    
                    <input type="hidden" name="etapes_titre[]" value="${titre}">
                    <input type="hidden" name="etapes_desc[]" value="${desc}">
                </div>
            `;

            container.appendChild(div);

            // Reset
            document.getElementById('new_titre').value = "";
            document.getElementById('new_desc').value = "";
        }
    </script>
</body>
</html>