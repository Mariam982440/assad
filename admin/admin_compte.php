<?php
session_start();
require '../db.php'; // Remonter d'un dossier pour trouver db.php

// 1. SÉCURITÉ : Vérifier si c'est un ADMIN
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    die("Accès interdit.");
}

$message = "";

// 2. TRAITEMENT DES ACTIONS (Approuver ou Supprimer)
if (isset($_GET['id']) && isset($_GET['action'])) {
    
    $id_user = intval($_GET['id']);
    $action = $_GET['action'];

    if ($action == 'approve') {
        // On met est_approuve à 1
        $sql = "UPDATE utilisateur SET est_approuve = 1 WHERE id_usr = $id_user";
        if (mysqli_query($conn, $sql)) {
            $message = "<div class='bg-green-100 text-green-700 p-3 rounded mb-4'>Le compte a été approuvé avec succès. Le guide peut maintenant se connecter.</div>";
        }
    } 
    elseif ($action == 'delete') {
        // On supprime le compte (Refus)
        $sql = "DELETE FROM utilisateur WHERE id_usr = $id_user";
        if (mysqli_query($conn, $sql)) {
            $message = "<div class='bg-red-100 text-red-700 p-3 rounded mb-4'>La demande a été refusée et le compte supprimé.</div>";
        }
    }
}

// 3. RÉCUPÉRATION DES GUIDES NON APPROUVÉS
// On cherche : Rôle = guide ET est_approuve = 0
$sql_waiting = "SELECT * FROM utilisateur WHERE role_usr = 'guide' AND est_approuve = 0 ORDER BY id_usr DESC";
$result = mysqli_query($conn, $sql_waiting);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Comptes - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">

    <!-- NAVBAR ADMIN -->
    <nav class="bg-red-900 text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="font-bold text-xl flex items-center gap-2">
                <i class="fas fa-user-shield text-yellow-400"></i> ESPACE ADMIN
            </div>
            <div class="space-x-4">
                <a href="../animal.php" class="hover:text-yellow-200">Accueil</a>
                <a href="admin_compte.php" class="text-yellow-300 font-bold border-b-2 border-yellow-300">Gérer Comptes</a>
                <a href="admin_panel.php" class="hover:text-yellow-200">Statistiques</a>
                <a href="../logout.php" class="bg-gray-900 px-3 py-1 rounded hover:bg-black text-sm">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-8">
        
        <h1 class="text-3xl font-bold text-gray-800 mb-6 border-b pb-2">
            <i class="fas fa-users-cog mr-2"></i>Validations en attente
        </h1>

        <?= $message ?>

        <!-- TABLEAU DES DEMANDES -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            
            <?php if(mysqli_num_rows($result) == 0): ?>
                <div class="p-8 text-center text-gray-500">
                    <i class="fas fa-check-circle text-4xl text-green-500 mb-4"></i>
                    <p class="text-lg">Aucune demande en attente.</p>
                    <p class="text-sm">Tous les guides sont à jour.</p>
                </div>
            <?php else: ?>

                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-bold">
                        <tr>
                            <th class="p-4 border-b">Nom du Guide</th>
                            <th class="p-4 border-b">Email</th>
                            <th class="p-4 border-b text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <tr class="hover:bg-yellow-50 transition">
                                <td class="p-4 font-bold text-gray-800"><?= htmlspecialchars($row['nom_usr']) ?></td>
                                <td class="p-4 text-blue-600"><?= htmlspecialchars($row['email_usr']) ?></td>
                                <td class="p-4 text-center space-x-2">
                                    
                                    <!-- Bouton APPROUVER -->
                                    <a href="admin_compte.php?id=<?= $row['id_usr'] ?>&action=approve" 
                                       class="inline-flex items-center bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 shadow transition text-sm">
                                        <i class="fas fa-check mr-2"></i> Approuver
                                    </a>

                                    <!-- Bouton REFUSER (Supprimer) -->
                                    <a href="admin_compte.php?id=<?= $row['id_usr'] ?>&action=delete" 
                                       onclick="return confirm('Êtes-vous sûr de vouloir rejeter cette demande ? Le compte sera supprimé.')"
                                       class="inline-flex items-center bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 shadow transition text-sm">
                                        <i class="fas fa-times mr-2"></i> Rejeter
                                    </a>

                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

            <?php endif; ?>
        </div>

        <!-- Section Liste complète (Optionnel : pour voir les comptes déjà validés) -->
        <div class="mt-12">
            <h2 class="text-xl font-bold text-gray-700 mb-4">Guides déjà validés</h2>
            <div class="bg-gray-100 p-4 rounded text-sm text-gray-600">
                <?php
                //  requête pour afficher le nombre de guides actifs
                $count_active = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM utilisateur WHERE role_usr='guide' AND est_approuve=1"));
                echo "Il y a actuellement <b>" . $count_active['total'] . "</b> guides actifs sur la plateforme.";
                ?>
            </div>
        </div>

    </div>

</body>
</html>