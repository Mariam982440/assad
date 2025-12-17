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

    <!-- NAVBAR (Statique pour l'instant) -->
    <nav class="bg-green-800 text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="text-xl font-bold flex items-center gap-2">
                <i class="fas fa-paw text-yellow-400"></i> ASSAD ZOO
            </div>
            <div class="hidden md:flex space-x-6">
                <a href="index.html" class="hover:text-yellow-200">Accueil</a>
                <a href="#" class="text-yellow-300 font-bold border-b-2 border-yellow-300">Les Animaux</a>
                <a href="#" class="hover:text-yellow-200">Visites</a>
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
            
            <!-- BOUTON AJOUTER (Visible seulement si Admin - Simulation visuelle) -->
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 shadow flex items-center gap-2 transition">
                <i class="fas fa-plus-circle"></i> Ajouter un animal
            </button>
        </div>
    </header>

    <div class="container mx-auto px-6 py-8">

        <!-- BARRE DE FILTRES -->
        <div class="bg-white p-4 rounded-lg shadow mb-8 border border-gray-200">
            <form class="flex flex-col md:flex-row gap-4 items-center">
                
                <!-- Recherche par nom -->
                <div class="relative w-full md:w-1/3">
                    <input type="text" placeholder="Rechercher un animal (ex: Lion)..." class="w-full pl-10 pr-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>

                <!-- Filtre Habitat -->
                <select class="w-full md:w-1/4 border p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                    <option value="">Tous les habitats</option>
                    <option value="Savane">Savane</option>
                    <option value="Jungle">Jungle</option>
                    <option value="Montagne">Montagne</option>
                    <option value="Désert">Désert</option>
                </select>

                <!-- Filtre Pays -->
                <select class="w-full md:w-1/4 border p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                    <option value="">Tous les pays</option>
                    <option value="Maroc">Maroc</option>
                    <option value="Kenya">Kenya</option>
                    <option value="Sénégal">Sénégal</option>
                </select>

                <!-- Bouton Filtrer -->
                <button type="button" class="w-full md:w-auto bg-green-700 text-white px-6 py-2 rounded-lg hover:bg-green-800 font-bold transition">
                    Filtrer
                </button>
            </form>
        </div>

        <!-- GRILLE DES ANIMAUX -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">

            <!-- CARTE 1 : Lion (Vue Standard) -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 card group">
                <div class="relative h-56 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1614027164847-1b28cfe1df60?w=600" alt="Lion" class="w-full h-full object-cover card-img">
                    <div class="absolute top-2 right-2 bg-yellow-400 text-xs font-bold px-2 py-1 rounded shadow">STAR</div>
                </div>
                <div class="p-5">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-xl font-bold text-gray-800">Lion de l'Atlas</h3>
                        <span class="bg-gray-200 text-gray-600 text-xs px-2 py-1 rounded-full">Montagne</span>
                    </div>
                    <p class="text-sm text-gray-500 mb-4"><i class="fas fa-map-marker-alt text-red-500 mr-1"></i> Maroc</p>
                    
                    <a href="#" class="block w-full bg-green-100 text-green-800 text-center py-2 rounded font-bold hover:bg-green-200 transition">
                        Voir Fiche
                    </a>
                </div>
            </div>

            <!-- CARTE 2 : Éléphant (Vue Admin - Exemple) -->
            <!-- Cette carte montre à quoi ça ressemble quand l'admin est connecté -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 card group">
                <div class="relative h-56 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1557050543-4d5f4e07ef46?w=600" alt="Elephant" class="w-full h-full object-cover card-img">
                </div>
                <div class="p-5">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-xl font-bold text-gray-800">Éléphant</h3>
                        <span class="bg-orange-100 text-orange-800 text-xs px-2 py-1 rounded-full">Savane</span>
                    </div>
                    <p class="text-sm text-gray-500 mb-4"><i class="fas fa-map-marker-alt text-red-500 mr-1"></i> Kenya</p>
                    
                    <!-- ZONE ACTIONS ADMIN (À protéger avec PHP plus tard) -->
                    <div class="flex gap-2">
                        <a href="#" class="flex-1 bg-green-100 text-green-800 text-center py-2 rounded font-bold hover:bg-green-200 text-sm">
                            Voir
                        </a>
                        <a href="#" class="w-10 bg-blue-100 text-blue-600 flex items-center justify-center rounded hover:bg-blue-200">
                            <i class="fas fa-pen"></i>
                        </a>
                        <a href="#" class="w-10 bg-red-100 text-red-600 flex items-center justify-center rounded hover:bg-red-200">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- CARTE 3 : Fennec -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 card group">
                <div class="relative h-56 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1531594896955-305cf81269ce?w=600" alt="Fennec" class="w-full h-full object-cover card-img">
                </div>
                <div class="p-5">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-xl font-bold text-gray-800">Fennec</h3>
                        <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">Désert</span>
                    </div>
                    <p class="text-sm text-gray-500 mb-4"><i class="fas fa-map-marker-alt text-red-500 mr-1"></i> Algérie / Maroc</p>
                    
                    <a href="#" class="block w-full bg-green-100 text-green-800 text-center py-2 rounded font-bold hover:bg-green-200 transition">
                        Voir Fiche
                    </a>
                </div>
            </div>

            <!-- CARTE 4 : Zèbre -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 card group">
                <div class="relative h-56 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1504204267155-aaad8e81290d?w=600" alt="Zèbre" class="w-full h-full object-cover card-img">
                </div>
                <div class="p-5">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-xl font-bold text-gray-800">Zèbre</h3>
                        <span class="bg-orange-100 text-orange-800 text-xs px-2 py-1 rounded-full">Savane</span>
                    </div>
                    <p class="text-sm text-gray-500 mb-4"><i class="fas fa-map-marker-alt text-red-500 mr-1"></i> Tanzanie</p>
                    
                    <a href="#" class="block w-full bg-green-100 text-green-800 text-center py-2 rounded font-bold hover:bg-green-200 transition">
                        Voir Fiche
                    </a>
                </div>
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