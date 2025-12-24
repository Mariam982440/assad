<?php
session_start();
require '../db.php'; // Vérifie que le chemin vers db.php est bon

// 1. SÉCURITÉ : Vérifier si c'est un VISITEUR
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'visiteur') {
    header("Location: ../login.php");
    exit();
}

// On affiche TOUTES les visites, triées par date
$sql = "SELECT v.*, u.nom_usr AS nom_guide 
        FROM visite_guidee v 
        LEFT JOIN utilisateur u ON v.id_utilisateur = u.id_usr 
        ORDER BY v.dateheure DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Visites</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">

    <!-- NAVBAR VISITEUR -->
    <nav class="bg-green-800 text-white p-4 shadow-lg mb-8">
        <div class="container mx-auto flex justify-between items-center">
            <div class="font-bold text-xl">🦁 ASSAD ZOO</div>
            <div class="space-x-4">
                <a href="../animal.php" class="hover:text-yellow-300">Accueil</a>
                <a href="visiteur_tours.php" class=" px-3 py-1 rounded">Les visites disponibles</a>
                <a href="visiteur_dashboard.php" class="hover:text-yellow-300">Mes Réservations</a>
                <a href="../logout.php" class="bg-red-600 px-3 py-1 rounded text-sm">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6 pb-12">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Toutes les Visites Guidées</h1>

        <!-- GRILLE DES VISITES -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            <?php if(mysqli_num_rows($result) == 0): ?>
                <div class="col-span-3 text-center text-gray-500 py-10">
                    Aucune visite trouvée dans la base de données.
                </div>
            <?php endif; ?>

            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <?php
                    // CALCUL DES PLACES (Indispensable pour la réservation)
                    $id_v = $row['id'];
                    // On compte combien de personnes sont déjà inscrites
                    $q_res = mysqli_query($conn, "SELECT SUM(nbpersonnes) as total FROM reservations WHERE id_visite = $id_v");
                    $d_res = mysqli_fetch_assoc($q_res);
                    
                    $places_prises = $d_res['total'] ? $d_res['total'] : 0;
                    $places_restantes = $row['capacite_max'] - $places_prises;
                    
                    // Formatage simple
                    $date_fmt = date("d/m/Y H:i", strtotime($row['dateheure']));
                ?>

                <!-- CARTE VISITE -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                    
                    <!-- En-tête -->
                    <div class="bg-green-100 p-4 border-b border-green-200 flex justify-between">
                        <h3 class="font-bold text-lg text-green-900"><?= htmlspecialchars($row['titre']) ?></h3>
                        <span class="font-bold text-green-800"><?= $row['prix'] ?> DH</span>
                    </div>
                    
                    <!-- Corps -->
                    <div class="p-4 space-y-2">
                        <p class="text-sm text-gray-600"><span class="font-bold">Guide :</span> <?= htmlspecialchars($row['nom_guide'] ?? 'Inconnu') ?></p>
                        <p class="text-sm text-gray-600"><span class="font-bold">Date :</span> <?= $date_fmt ?></p>
                        <p class="text-sm text-gray-600"><span class="font-bold">Langue :</span> <?= htmlspecialchars($row['langue']) ?></p>
                        
                        <!-- Places restantes -->
                        <div class="mt-2 text-sm">
                            Places : <span class="font-bold <?= $places_restantes > 0 ? 'text-green-600' : 'text-red-600' ?>">
                                <?= $places_prises ?> / <?= $row['capacite_max'] ?>
                            </span>
                        </div>
                    </div>

                    <!-- FORMULAIRE DE RÉSERVATION -->
                    <div class="p-4 bg-gray-50 border-t border-gray-200">
    <?php if($places_restantes > 0): ?>
        
        <form action="reserv_tours.php" method="POST">
            <!-- ID de la visite (Caché) -->
            <input type="hidden" name="id_visite" value="<?= $id_v ?>">
            
            <div class="flex items-end gap-3">
                
                <!-- ZONE DE SAISIE DU NOMBRE DE MEMBRES -->
                <div class="flex-1">
                    <label class="block text-xs font-bold text-gray-700 mb-1">
                        Nombre de places :
                    </label>
                    <input type="number" 
                           name="nb_personnes" 
                           value="1" 
                           min="1" 
                           max="<?= $places_restantes ?>" 
                           class="w-full border border-gray-300 rounded p-2 text-center font-bold text-gray-800 focus:outline-none focus:ring-2 focus:ring-green-500" 
                           required>
                </div>

                <!-- BOUTON RESERVER -->
                <button type="submit" name="book" class="bg-red-600 text-white font-bold py-2 px-6 rounded hover:bg-red-700 transition shadow-md h-[42px]">
                    Réserver
                </button>
            </div>
            
            <!-- Petit message d'info -->
            <p class="text-xs text-gray-500 mt-2">
                * Maximum <?= $places_restantes ?> personnes possibles.
            </p>
        </form>

    <?php else: ?>
        <button disabled class="w-full bg-gray-300 text-gray-500 font-bold py-2 rounded cursor-not-allowed uppercase tracking-wider">
            Complet
        </button>
    <?php endif; ?>
</div>

                </div>
            <?php endwhile; ?>

        </div>
    </div>
</body>
</html>