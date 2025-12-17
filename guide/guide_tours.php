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
                <a href="guide_tours.php" class="text-yellow-300 font-bold border-b-2 border-yellow-300">Gérer mes Visites</a>
                <a href="guide_reservations.php" class="hover:text-yellow-200">Voir Réservations</a>
                <a href="logout.php" class="bg-red-600 px-3 py-1 rounded hover:bg-red-700 text-sm">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-8">
        
        <!-- SECTION 1: FORMULAIRE DE CRÉATION / MODIFICATION -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-10 border-t-4 border-blue-600">
            <h2 class="text-2xl font-bold text-gray-800 mb-6"><i class="fas fa-plus-circle mr-2"></i>Créer / Modifier une Visite</h2>
            
            <form action="process_guide.php" method="POST">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Infos de base -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Titre de la visite</label>
                        <input type="text" name="titre" class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:border-blue-500" placeholder="Ex: Safari des Lions">
                    </div>

                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Langue</label>
                        <select name="langue" class="w-full border border-gray-300 p-2 rounded">
                            <option>Français</option>
                            <option>Arabe</option>
                            <option>Anglais</option>
                        </select>
                    </div>

                    <div class="flex gap-4">
                        <div class="w-1/2">
                            <label class="block text-gray-700 font-bold mb-2">Date</label>
                            <input type="date" name="date" class="w-full border border-gray-300 p-2 rounded">
                        </div>
                        <div class="w-1/2">
                            <label class="block text-gray-700 font-bold mb-2">Heure Début</label>
                            <input type="time" name="heure" class="w-full border border-gray-300 p-2 rounded">
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="w-1/2">
                            <label class="block text-gray-700 font-bold mb-2">Prix (MAD)</label>
                            <input type="number" name="prix" class="w-full border border-gray-300 p-2 rounded" placeholder="50">
                        </div>
                        <div class="w-1/2">
                            <label class="block text-gray-700 font-bold mb-2">Capacité Max</label>
                            <input type="number" name="capacite" class="w-full border border-gray-300 p-2 rounded" placeholder="20">
                        </div>
                    </div>

                    <!-- GESTION DES ÉTAPES (PARCOURS) -->
                    <div class="md:col-span-2 bg-blue-50 p-4 rounded border border-blue-200">
                        <h3 class="font-bold text-blue-900 mb-3"><i class="fas fa-map-signs mr-2"></i>Définir le Parcours (Étapes)</h3>
                        
                        <!-- Zone pour ajouter une étape -->
                        <div class="flex gap-2 mb-4">
                            <input type="text" placeholder="Titre de l'étape (ex: Zone Savane)" class="flex-1 border p-2 rounded">
                            <input type="number" placeholder="Ordre" class="w-20 border p-2 rounded" value="1">
                            <button type="button" class="bg-green-600 text-white px-4 rounded hover:bg-green-700">Ajouter</button>
                        </div>

                        <!-- Liste des étapes ajoutées (Aperçu) -->
                        <ul class="space-y-2">
                            <li class="bg-white p-2 rounded shadow-sm flex justify-between items-center border-l-4 border-green-500">
                                <span><span class="font-bold text-gray-500 mr-2">1.</span> Présentation Lions de l'Atlas</span>
                                <button class="text-red-500 text-sm hover:underline">Supprimer</button>
                            </li>
                            <li class="bg-white p-2 rounded shadow-sm flex justify-between items-center border-l-4 border-green-500">
                                <span><span class="font-bold text-gray-500 mr-2">2.</span> Nourrissage des Crocodiles</span>
                                <button class="text-red-500 text-sm hover:underline">Supprimer</button>
                            </li>
                        </ul>
                    </div>

                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="reset" class="bg-gray-300 text-gray-700 px-6 py-2 rounded font-bold hover:bg-gray-400">Annuler</button>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded font-bold hover:bg-blue-700">Enregistrer la visite</button>
                </div>
            </form>
        </div>

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