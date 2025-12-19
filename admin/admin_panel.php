<?php
session_start();
require '../db.php'; 

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    die("Accès interdit : Vous n'êtes pas administrateur.");
}
$animal = "SELECT a.*,h.nom_hab from animal a LEFT JOIN habitatt h on a.id_habitat = h.id_hab";
$result_anl =mysqli_query($conn,$animal);


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">

    <nav class="bg-gray-900 text-white px-6 py-4 flex justify-between">
        <span class="font-bold text-xl">Admin Panel</span>
        <a href="asaad.html" class="text-sm hover:text-gray-300">Retour Site</a>
    </nav>

    <div class="container mx-auto px-6 py-8">
        
        <!-- STATISTIQUES -->
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Vue d'ensemble</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
                <div class="text-gray-500">Visiteurs Totaux</div>
                <div class="text-3xl font-bold">12,450</div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-green-500">
                <div class="text-gray-500">Animaux</div>
                <div class="text-3xl font-bold">42</div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-yellow-500">
                <div class="text-gray-500">Visites Réservées</div>
                <div class="text-3xl font-bold">158</div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow border-l-4 border-red-500">
                <div class="text-gray-500">Guides en attente</div>
                <div class="text-3xl font-bold">3</div>
            </div>
        </div>
            <!-- TABLEAU LISTE ANIMAUX -->
            <div class="lg:col-span-2 bg-white rounded-lg shadow overflow-hidden">
                <div class="p-4 border-b flex justify-between items-center bg-gray-50">
                    <h3 class="font-bold text-lg">Liste des Animaux</h3>
                    <input type="text" placeholder="Rechercher..." class="border p-1 rounded text-sm">
                </div>
                <table class="w-full text-left">
                    <thead class="bg-gray-100 text-gray-600 text-sm">
                        <tr>
                            <th class="p-3">Image</th>
                            <th class="p-3">Nom</th>
                            <th class="p-3">Habitat</th>
                            <th class="p-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    
                    <tbody class="divide-y text-sm">
                        <?php while($anl=mysqli_fetch_assoc($result_anl)):?>
                        <tr class="hover:bg-gray-50">
                            <td class="p-3"><img src="../uploads/<?= $anl['image']?>" class="w-10 h-10 rounded-full object-cover"></td>
                            <td class="p-3 font-medium"><?=$anl['nom_al']?></td>
                            <td class="p-3"><span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs"><?=$anl['nom_hab']?></span></td>
                            <td class="p-3 text-right">
                                <!-- <button class="text-blue-500 hover:text-blue-700 mr-2"><i class="fas fa-edit"></i></button> -->
                                <a href="edit_animal.php?id=<?= $anl['id_al'] ?>" class="text-blue-500 hover:text-blue-700 mr-2">
                                    <i class="fas fa-edit"></i> 
                                </a>
                                <a href="delete_animal.php?id=<?= $anl['id_al'] ?>" class="text-red-500 hover:text-red-700"
                                onclick="return confirm('Êtes-vous sûr ?')">
                                    <i class="fas fa-trash"></i> 
                                </a>
                            </td>
                        </tr>
                        <?php endwhile;?>
                         
                    </tbody>
                </table>
                <!-- Pagination -->
                <div class="p-3 border-t text-center text-sm text-gray-500">
                    
                    Page 1 sur 5
                </div>
            </div>

        </div>
    </div>

</body>
</html>