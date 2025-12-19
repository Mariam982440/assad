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
    <nav class="bg-blue-900 text-white shadow-lg">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="font-bold text-xl flex items-center gap-2">
                <i class="fas fa-compass text-yellow-400"></i> ESPACE GUIDE
            </div>
            <div class="space-x-4">
                <a href="guide_reservations.php" class="hover:text-yellow-200">Voir Réservations</a>
                <a href="logout.php" class="bg-red-600 px-3 py-1 rounded hover:bg-red-700 text-sm">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-8">
        <!-- bouton pour ajouter une visite -->
        <a href="add_tours.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-green-700 shadow">
            <i class="fas fa-plus-circle"></i> Ajouter une visite
        </a>
        <!-- SECTION 2: LISTE DE MES VISITES EXISTANTES -->
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Mes Visites Programmées</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Carte Visite 1 -->
            <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden relative">
                <div class="bg-green-100 text-green-800 text-xs font-bold px-2 py-1 absolute top-2 right-2 rounded">Active</div>
                <div class="p-5">
                    <h3 class="font-bold text-xl mb-1">Safari Nocturne</h3>
                    <p class="text-sm text-gray-500 mb-4">25 Jan 2025 à 20:00 • 2h00</p>
                    
                    <div class="text-sm bg-gray-50 p-2 rounded mb-4">
                        <span class="font-bold">Parcours :</span> Lions → Hyènes → Reptiles
                    </div>

                    <div class="flex justify-between items-center border-t pt-4">
                        <div class="text-sm text-gray-600">Inscrits: <span class="font-bold text-black">12/20</span></div>
                        <div class="flex gap-2">
                            <button class="text-blue-600 hover:bg-blue-50 px-3 py-1 rounded"><i class="fas fa-edit"></i> Modifier</button>
                            <button class="text-red-600 hover:bg-red-50 px-3 py-1 rounded"><i class="fas fa-trash-alt"></i> Annuler</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carte Visite 2 (Annulée) -->
            <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden relative opacity-75">
                <div class="bg-red-100 text-red-800 text-xs font-bold px-2 py-1 absolute top-2 right-2 rounded">Annulée</div>
                <div class="p-5">
                    <h3 class="font-bold text-xl mb-1 text-gray-600">Découverte Atlas</h3>
                    <p class="text-sm text-gray-500 mb-4">26 Jan 2025 à 10:00 • 1h30</p>
                    
                    <div class="flex justify-between items-center border-t pt-4">
                        <div class="text-sm text-gray-600">Inscrits: 0/15</div>
                        <button class="text-blue-600 hover:bg-blue-50 px-3 py-1 rounded"><i class="fas fa-redo"></i> Réactiver</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>