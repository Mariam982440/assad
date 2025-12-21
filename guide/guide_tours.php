<?php
session_start();
require '../db.php'; // Connexion BDD

// 1. SÉCURITÉ : Vérifier si c'est un GUIDE
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'guide') {
    header("Location: ../login.php");
    exit();
}

$id_guide = $_SESSION['user_id'];

// On sélectionne toutes les visites créées par ce guide, triées par date (la plus récente en premier)
$sql = "SELECT * FROM visite_guidee WHERE id_utilisateur = $id_guide ORDER BY dateheure DESC";
$result = mysqli_query($conn, $sql);
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

    <!-- NAVBAR GUIDE -->
    <nav class="bg-blue-900 text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="font-bold text-xl flex items-center gap-2">
                <i class="fas fa-compass text-yellow-400"></i> ESPACE GUIDE
            </div>
            <div class="space-x-4 flex items-center">
                <span class="text-gray-300 text-sm mr-2">Bonjour, <?= htmlspecialchars($_SESSION['nom']) ?></span>
                <a href="../asaad.php" class="hover:text-yellow-200">Accueil</a>
                <a href="guide_tours.php" class="text-yellow-300 font-bold border-b-2 border-yellow-300">Mes Visites</a>
                <a href="guide_reservations.php" class="hover:text-yellow-200">Voir Réservations</a>
                <a href="../logout.php" class="bg-red-600 px-3 py-1 rounded hover:bg-red-700 text-sm">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-8">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Mes Visites Programmées</h2>
            <!-- bouton ajouter -->
            <a href="add_tours.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 shadow transition flex items-center gap-2">
                <i class="fas fa-plus-circle"></i> Ajouter une visite
            </a>
        </div>

        <!-- liste des visites -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <?php if (mysqli_num_rows($result) == 0): ?>
                <div class="col-span-2 text-center text-gray-500 py-10">
                    <p>Vous n'avez pas encore créé de visites.</p>
                </div>
            <?php endif; ?>

            <?php while($visite = mysqli_fetch_assoc($result)): ?>
                <?php 
                    // récupérer le nombre d'inscrits pour cette visite
                    $id_v = $visite['id'];
                    $sql_count = "SELECT SUM(nbpersonnes) as total_places FROM reservations WHERE id_visite = $id_v";
                    $res_count = mysqli_query($conn, $sql_count);
                    $row_count = mysqli_fetch_assoc($res_count);

                    // Si la somme est NULL (aucune réservation), on met 0, sinon on prend le chiffre
                    $inscrits = $row_count['total_places'] ? $row_count['total_places'] : 0;

                    // récupérer les étapes pour l'affichage (Concaténées)
                    $sql_etapes = "SELECT titreetape FROM etapesvisite WHERE id_visite = $id_v ORDER BY ordreetape ASC";
                    $res_etapes = mysqli_query($conn, $sql_etapes);
                    $parcours = [];
                    while($e = mysqli_fetch_assoc($res_etapes)) {
                        $parcours[] = $e['titreetape'];
                    }
                    $parcours_txt = implode(" → ", $parcours); // Ex: Lions → Singes

                     //C. gestion du style selon le statut (Active / Annulée / Terminée)
                    
                        // 1. On récupère la date actuelle
                        $now = date("Y-m-d H:i:s");

                        // 2. Logique de décision (Ordre de priorité important)

                        if ($visite['statut'] == 'annulee') {
                            // PRIORITÉ 1 : Si annulée
                            $statut_label = 'Annulée';
                            $card_opacity = "opacity-75 bg-gray-100";
                            $badge_color  = "bg-red-100 text-red-800";
                            $is_cancelled = true;

                        } elseif ($visite['dateheure'] < $now) {
                            // PRIORITÉ 2 : Si la date est passée (et pas annulée)
                            $statut_label = 'Terminée';
                            $card_opacity = "opacity-75 bg-gray-50"; // Un peu grisé
                            $badge_color  = "bg-gray-200 text-gray-700"; // Gris pour terminé
                            $is_cancelled = false; // Elle n'est pas annulée, juste finie

                        } else {
                            // SINON : Elle est active (future)
                            $statut_label = 'Active';
                            $card_opacity = "bg-white";
                            $badge_color  = "bg-green-100 text-green-800";
                            $is_cancelled = false;
                        }
                        
                    
                    // formatage date
                    $date_fmt = date("d/m/Y à H:i", strtotime($visite['dateheure']));
                ?>

                <!-- carte visite -->
                <div class="<?= $card_opacity ?> rounded-lg shadow border border-gray-200 overflow-hidden relative transition hover:shadow-lg">
                    
                    <!-- badge statut -->
                    <div class="<?= $badge_color ?> text-xs font-bold px-2 py-1 absolute top-2 right-2 rounded">
                        <?= $statut_label ?>
                    </div>

                    <div class="p-5">
                        <h3 class="font-bold text-xl mb-1 text-gray-800"><?= htmlspecialchars($visite['titre']) ?></h3>
                        <p class="text-sm text-gray-500 mb-4">
                            <i class="far fa-calendar-alt mr-1"></i> <?= $date_fmt ?> • 
                            <i class="far fa-clock mr-1"></i> <?= $visite['duree'] ?> min
                        </p>
                        
                        <!-- parcours -->
                        <?php if(!empty($parcours_txt)): ?>
                        <div class="text-sm bg-blue-50 text-blue-900 p-2 rounded mb-4 border border-blue-100">
                            <span class="font-bold"><i class="fas fa-map-signs"></i> Parcours :</span> <?= htmlspecialchars($parcours_txt) ?>
                        </div>
                        <?php else: ?>
                            <div class="text-sm text-gray-400 mb-4 italic">Aucune étape définie.</div>
                        <?php endif; ?>

                        <!-- pied de carte -->
                        <div class="flex justify-between items-center border-t pt-4">
                            <div class="text-sm text-gray-600">
                                Inscrits: <span class="font-bold text-black"><?= $inscrits ?> / <?= $visite['capacite_max'] ?></span>
                            </div>
                            
                            <div class="flex gap-2">
                                <!-- bouton modifier -->
                                <a href="edit_tours.php?id=<?= $visite['id'] ?>" class="text-blue-600 hover:bg-blue-50 px-3 py-1 rounded text-sm font-bold border border-blue-200">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>

                                
                                <?php if(!$is_cancelled): ?>
                                    <a href="cancel_tours.php?id=<?= $visite['id'] ?>" onclick="return confirm('Voulez-vous vraiment annuler cette visite ?')" class="text-red-600 hover:bg-red-50 px-3 py-1 rounded text-sm font-bold border border-red-200">
                                        <i class="fas fa-ban"></i> Annuler
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endwhile; ?>

        </div>
    </div>
</body>
</html>