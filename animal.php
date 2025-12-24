<?php
require_once 'db.php';
session_start();

if(!isset($_SESSION['user_id'])){
    header("location: login.php");
    exit();
}

$nom = $_SESSION['nom'];
$role = $_SESSION['role'];

$habitats = mysqli_query($conn, "SELECT * FROM habitatt");
$pays = mysqli_query($conn, "SELECT distinct paysorigine FROM animal WHERE paysorigine IS NOT NULL AND paysorigine != ''");

$filtre_habitat = isset($_GET['habitat']) ? $_GET['habitat'] : "";
$filtre_pays    = isset($_GET['pays']) ? $_GET['pays'] : "";

$sql="SELECT a.*,h.nom_hab from animal a LEFT JOIN habitatt h on a.id_habitat = h.id_hab where 1";

//filtre habitat
if ($filtre_habitat !== "") {
    $sql .= " AND animal.habitat_id = " . intval($filtreHabitat);
}
//filtre pays
if ($filtre_pays !== "") {
    $safe_pays = mysqli_real_escape_string($conn, $filtre_pays);
    $sql .= " AND a.paysorigine = '$safe_pays'";
}
$result =mysqli_query($conn,$sql);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Animaux - ASSAD Zoo</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* Petite touche pour les images */
        .card-img { transition: transform 0.3s ease; }
        .card:hover .card-img { transform: scale(1.05); }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    
    <nav class="bg-green-800 text-white shadow-lg sticky top-0 z-50">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
        <div class="text-xl font-bold flex items-center gap-2">
            <i class="fas fa-paw text-yellow-400"></i> ASSAD ZOO
        </div>
        
        <div class="hidden md:flex space-x-6 items-center">
            <span class="text-yellow-300 font-bold">Bonjour, <?= $nom ?> (<?= $role ?>)</span>
            
            <a href="assad.php" class="hover:text-yellow-200">Accueil</a>
            
            <!-- lien visible seulement pour le GUIDE -->
            <?php if($role == 'guide'): ?>
                <a href="guide/guide_reservations.php" class=" px-3 py-1 rounded"> Réservations</a>
                <a href="guide/guide_tours.php" class=" px-3 py-1 rounded"> Visites </a>
            <?php endif; ?>

            <!-- lien visible seulement pour l'ADMIN -->
            <?php if($role == 'admin'): ?>
                <a href="admin/admin_compte.php" class=" px-3 py-1 rounded">Comptes</a>
                <a href="admin/admin_panel.php" class=" px-3 py-1 rounded">Statistiques</a>
            <?php endif; ?>
            
            <!-- lien visible seulement pour le visiteur-->
            <?php if($role=='visiteur'):?>
            <a href="visiteur/visiteur_tours.php" class=" px-3 py-1 rounded">Les visites disponibles</a>
            <a href="visiteur/visiteur_dashboard.php" class=" px-3 py-1 rounded">Mes réservations</a>
            <?php endif; ?>

            <a href="logout.php" class="bg-gray-700 px-3 py-1 rounded hover:bg-gray-800">Déconnexion</a>
        </div>
    </div>
</nav>

    <!-- EN-TÊTE DE PAGE -->
    <header class="bg-white shadow-sm py-10">
        <div class="container mx-auto px-6 flex justify-between items-end">
            <div>
                <h1 class="text-3xl font-bold text-green-900 mb-2">La Faune Africaine</h1>
                <p class="text-gray-600">Découvrez les espèces protégées et leurs habitats naturels.</p>
            </div>
            
            <!-- seulement l'admin voit ce bouton-->
            <?php if($role == 'admin'): ?>
                <a href="admin/add_animal.php" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 shadow">
                    <i class="fas fa-plus-circle"></i> Ajouter un animal
                </a>
                <a href="admin/add_habitat.php" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 shadow">
                    <i class="fas fa-plus-circle"></i> Ajouter un habitat
                </a>
            <?php endif; ?>
            
        </div>
    </header>

    <div class="container mx-auto px-6 py-8">

        <!-- BARRE DE FILTRES -->
        <div class="bg-white p-4 rounded-lg shadow mb-8 border border-gray-200">
            <form class="flex flex-col md:flex-row gap-4 items-center">
                
                <!-- Recherche par nom -->
                <div class="relative w-full md:w-1/3">
                    <input name="nom_rech" type="text" placeholder="Rechercher un animal (ex: Lion)..." class="w-full pl-10 pr-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>

                <!-- filtre hab -->
                <select name="filtre_hab" class="w-full md:w-1/4 border p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                    <option value="">Tous les habitats</option>
                    <?php while($hab=mysqli_fetch_assoc($habitats)):?>
                    <option value="<?= $hab['nom_hab']?>" <?= ($filtre_habitat==$hab['nom_hab']) ? 'selected':""?>>
                        <?= $hab['nom_hab'] ?>
                    </option>
                    <?php endwhile; ?>
                </select>

                <!-- filtre pays -->
                <select name="filtre_pays" class="w-full md:w-1/4 border p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                    <option value="">Tous les pays</option>
                    <?php while($pay=mysqli_fetch_assoc($pays)):?>
                    <option value="<?= $pay['paysorigine']?>" <?= ($filtre_pays==$hab['paysorigine']) ? 'selected':""?>>
                        <?= $pay['paysorigine'] ?>
                    </option>
                    <?php endwhile; ?>
                </select>

                <!-- Bouton Filtrer -->
                <button type="submit" class="w-full md:w-auto bg-green-700 text-white px-6 py-2 rounded-lg hover:bg-green-800 font-bold transition">
                    Filtrer
                </button>
            </form>
        </div>

        
        <!-- GRILLE DES ANIMAUX -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200">
                    
                    <!-- Image (On gère le cas où il n'y a pas d'image) -->
                    <?php $imgSrc = !empty($row['image']) ? "uploads/".$row['image'] : "https://via.placeholder.com/300"; ?>
                    <img src="<?= $imgSrc ?>" alt="<?= $row['nom_al'] ?>" class="w-full h-48 object-cover">
                    
                    <div class="p-4">
                        <div class="flex justify-between items-start">
                            <h3 class="text-xl font-bold"><?= $row['nom_al'] ?></h3>
                            <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded">
                                <?= $row['nom_hab'] ?? 'Aucun habitat' ?>
                            </span>
                        </div>
                        <p class="text-gray-600 text-sm mt-2"><?= substr($row['descriptioncourte'], 0, 80) ?>...</p>
                        
                        <!-- seulement pour l'admin -->
                        <?php if($role == 'admin'): ?>
                            <div class="mt-4 flex gap-2 border-t pt-3">
                                <a href="admin/edit_animal.php?id=<?= $row['id_al'] ?>" class="flex-1 bg-blue-100 text-blue-600 py-1 rounded text-center hover:bg-blue-200">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>
                                <a href="admin/delete_animal.php?id=<?= $row['id_al'] ?>" onclick="return confirm('Êtes-vous sûr ?')" 
                                    class="flex-1 bg-red-100 text-red-600 py-1 rounded text-center hover:bg-red-200">
                                    <i class="fas fa-trash"></i> Supprimer
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>

        </div>

        </div>

        <!-- PAGINATION -->
        <div class="flex justify-center mt-12">
            <nav class="flex items-center gap-2">
                <a href="#" class="w-10 h-10 flex items-center justify-center rounded border hover:bg-gray-100 text-gray-500">
                    <i class="fas fa-chevron-left"></i>
                </a>
                <a href="#" class="w-10 h-10 flex items-center justify-center rounded bg-green-800 text-white font-bold shadow">1</a>
                <a href="#" class="w-10 h-10 flex items-center justify-center rounded border hover:bg-gray-100 text-gray-700 font-bold">2</a>
                <a href="#" class="w-10 h-10 flex items-center justify-center rounded border hover:bg-gray-100 text-gray-700 font-bold">3</a>
                <a href="#" class="w-10 h-10 flex items-center justify-center rounded border hover:bg-gray-100 text-gray-500">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </nav>
        </div>

    </div>

    <!-- FOOTER SIMPLE -->
    <footer class="bg-gray-900 text-white py-6 mt-12 text-center">
        <p class="text-sm">ASSAD Zoo © 2025 - CAN Maroc</p>
    </footer>

</body>
</html>