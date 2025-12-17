<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Historique - ASSAD Zoo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">

    <nav class="bg-green-800 text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="font-bold text-xl flex items-center gap-2">
                <i class="fas fa-paw text-yellow-400"></i> ASSAD ZOO
            </div>
            <div class="space-x-4">
                <a href="visitor_tours.php" class="hover:text-yellow-200">Réserver une visite</a>
                <a href="visitor_dashboard.php" class="text-yellow-300 font-bold border-b-2 border-yellow-300">Mes Réservations & Avis</a>
                <a href="logout.php" class="bg-red-600 px-3 py-1 rounded hover:bg-red-700 text-sm">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-10">
        
        <!-- SECTION 1: VISITES À VENIR -->
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-ticket-alt text-green-600 mr-3"></i> Mes Prochaines Visites
        </h2>

        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-12">
            <table class="w-full text-left">
                <thead class="bg-gray-100 text-gray-600 uppercase text-sm">
                    <tr>
                        <th class="p-4">Visite</th>
                        <th class="p-4">Date & Heure</th>
                        <th class="p-4">Places</th>
                        
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 font-bold text-green-800">Les Rois de l'Atlas</td>
                        <td class="p-4">25 Jan 2025 - 14:00</td>
                        <td class="p-4">2 Personnes</td>
                        
                    </tr>
                </tbody>
            </table>
        </div>


        <!-- SECTION 2: HISTORIQUE ET AVIS (La partie importante) -->
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-history text-yellow-600 mr-3"></i> Historique & Avis
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- CARTE VISITE DÉJÀ PASSÉE (Pas encore notée) -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-400">
                <div class="flex justify-between mb-4">
                    <div>
                        <h3 class="font-bold text-xl">Safari Nocturne</h3>
                        <p class="text-sm text-gray-500">10 Jan 2025</p>
                    </div>
                    <span class="bg-gray-200 text-gray-600 px-2 py-1 rounded text-xs h-fit">Terminé</span>
                </div>

                <p class="text-sm text-gray-600 mb-4">Comment s'est passée votre visite ? Donnez votre avis pour aider les autres visiteurs.</p>

                <!-- FORMULAIRE DE COMMENTAIRE -->
                <form action="submit_review.php" method="POST" class="bg-gray-50 p-4 rounded border border-gray-200">
                    <input type="hidden" name="id_visite" value="99">
                    
                    <!-- Système de notation (Stars) -->
                    <div class="mb-3">
                        <label class="block text-xs font-bold text-gray-700 mb-1">Votre Note :</label>
                        <div class="flex gap-2 text-xl text-gray-300 cursor-pointer">
                            <!-- En JS on changerait la couleur au clic, ici HTML pur -->
                            <i class="fas fa-star hover:text-yellow-400 text-yellow-400"></i>
                            <i class="fas fa-star hover:text-yellow-400 text-yellow-400"></i>
                            <i class="fas fa-star hover:text-yellow-400 text-yellow-400"></i>
                            <i class="fas fa-star hover:text-yellow-400 text-yellow-400"></i>
                            <i class="fas fa-star hover:text-yellow-400"></i>
                            <input type="hidden" name="note" value="4"> <!-- Valeur cachée simulée -->
                        </div>
                    </div>

                    <div class="mb-3">
                        <textarea name="commentaire" rows="3" class="w-full border p-2 rounded text-sm" placeholder="Ex: Le guide était super, les lions magnifiques..."></textarea>
                    </div>

                    <button type="submit" class="bg-yellow-500 text-white w-full py-2 rounded font-bold hover:bg-yellow-600 text-sm">
                        Envoyer mon avis
                    </button>
                </form>
            </div>

            <!-- CARTE VISITE DÉJÀ PASSÉE (Déjà notée) -->
            <div class="bg-white rounded-lg shadow-md p-6 opacity-75">
                <div class="flex justify-between mb-4">
                    <div>
                        <h3 class="font-bold text-xl">Découverte Reptiles</h3>
                        <p class="text-sm text-gray-500">05 Jan 2025</p>
                    </div>
                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs h-fit"><i class="fas fa-check"></i> Avis envoyé</span>
                </div>

                <div class="bg-gray-50 p-4 rounded border border-gray-200 italic text-gray-600 text-sm">
                    <div class="mb-2 text-yellow-400 text-xs">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    "Superbe expérience, les crocodiles étaient impressionnants !"
                </div>
            </div>

        </div>
    </div>

</body>
</html>