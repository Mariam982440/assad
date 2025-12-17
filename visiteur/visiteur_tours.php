<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réserver une Visite - ASSAD Zoo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">

    <!-- NAVBAR VISITEUR -->
    <nav class="bg-green-800 text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="font-bold text-xl flex items-center gap-2">
                <i class="fas fa-paw text-yellow-400"></i> ASSAD ZOO
            </div>
            <div class="space-x-4">
                <a href="asaad.php" class="hover:text-yellow-200">Accueil</a>
                <a href="visitor_tours.php" class="text-yellow-300 font-bold border-b-2 border-yellow-300">Réserver une visite</a>
                <a href="visitor_dashboard.php" class="hover:text-yellow-200">Mes Réservations & Avis</a>
                <a href="logout.php" class="bg-red-600 px-3 py-1 rounded hover:bg-red-700 text-sm">Déconnexion</a>
            </div>
        </div>
    </nav>

    <!-- HEADER -->
    <header class="bg-white shadow py-8 mb-8">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-3xl font-bold text-green-900">Explorez le Zoo en Direct</h1>
            <p class="text-gray-600 mt-2">Réservez votre place pour une visite guidée exclusive avec nos experts.</p>
        </div>
    </header>

    <div class="container mx-auto px-6 pb-12">
        
        <!-- FILTRES DE RECHERCHE -->
        <div class="flex flex-wrap gap-4 mb-8 justify-center">
            <input type="date" class="border p-2 rounded focus:ring-2 focus:ring-green-500">
            <select class="border p-2 rounded focus:ring-2 focus:ring-green-500">
                <option>Toutes les langues</option>
                <option>Français</option>
                <option>Arabe</option>
                <option>Anglais</option>
            </select>
            <button class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800"><i class="fas fa-search"></i> Rechercher</button>
        </div>

        <!-- GRILLE DES VISITES DISPONIBLES -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            <!-- CARTE VISITE 1 -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition">
                <div class="relative h-48 bg-gray-200">
                    <img src="https://images.unsplash.com/photo-1546182990-dffeafbe841d?w=600" alt="Lions" class="w-full h-full object-cover">
                    <div class="absolute top-2 right-2 bg-yellow-400 text-xs font-bold px-2 py-1 rounded shadow">Populaire</div>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-bold text-xl text-gray-800">Les Rois de l'Atlas</h3>
                        <span class="text-green-700 font-bold text-lg">50 DH</span>
                    </div>
                    
                    <div class="text-sm text-gray-600 space-y-2 mb-4">
                        <p><i class="far fa-calendar-alt w-5 text-green-600"></i> 25 Jan 2025</p>
                        <p><i class="far fa-clock w-5 text-green-600"></i> 14:00 (1h30)</p>
                        <p><i class="fas fa-language w-5 text-green-600"></i> Français</p>
                        <p><i class="fas fa-map-signs w-5 text-green-600"></i> Parcours : Lions -> Hyènes</p>
                    </div>

                    <!-- Barre de progression places -->
                    <div class="mb-4">
                        <div class="flex justify-between text-xs mb-1">
                            <span>Places restantes</span>
                            <span class="font-bold text-red-600">5 / 20</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" style="width: 75%"></div>
                        </div>
                    </div>

                    <!-- FORMULAIRE DE RÉSERVATION INTÉGRÉ -->
                    <form action="book_action.php" method="POST" class="mt-4 pt-4 border-t border-gray-100">
                        <input type="hidden" name="id_visite" value="1">
                        <div class="flex gap-2 items-center">
                            <input type="number" name="nb_personnes" min="1" max="5" value="1" class="w-16 border p-2 rounded text-center" title="Nombre de personnes">
                            <button type="submit" class="flex-1 bg-red-600 text-white py-2 rounded font-bold hover:bg-red-700 transition">
                                Réserver
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- CARTE VISITE 2 -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition">
                <div class="relative h-48 bg-gray-200">
                    <img src="https://images.unsplash.com/photo-1452570053594-1b985d6ea890?w=600" alt="Oiseaux" class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-bold text-xl text-gray-800">Oiseaux Exotiques</h3>
                        <span class="text-green-700 font-bold text-lg">40 DH</span>
                    </div>
                    
                    <div class="text-sm text-gray-600 space-y-2 mb-4">
                        <p><i class="far fa-calendar-alt w-5 text-green-600"></i> 26 Jan 2025</p>
                        <p><i class="far fa-clock w-5 text-green-600"></i> 10:00 (1h00)</p>
                        <p><i class="fas fa-language w-5 text-green-600"></i> Arabe</p>
                        <p><i class="fas fa-map-signs w-5 text-green-600"></i> Parcours : Volière -> Lac</p>
                    </div>

                    <div class="mb-4">
                        <div class="flex justify-between text-xs mb-1">
                            <span>Places restantes</span>
                            <span class="font-bold text-green-600">12 / 15</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" style="width: 20%"></div>
                        </div>
                    </div>

                    <form action="book_action.php" method="POST" class="mt-4 pt-4 border-t border-gray-100">
                        <input type="hidden" name="id_visite" value="2">
                        <div class="flex gap-2 items-center">
                            <input type="number" name="nb_personnes" min="1" max="12" value="1" class="w-16 border p-2 rounded text-center">
                            <button type="submit" class="flex-1 bg-red-600 text-white py-2 rounded font-bold hover:bg-red-700 transition">
                                Réserver
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</body>
</html>