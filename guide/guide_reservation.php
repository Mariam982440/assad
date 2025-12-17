<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Guide - Réservations</title>
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
                <a href="guide_tours.php" class="hover:text-yellow-200">Gérer mes Visites</a>
                <a href="guide_reservations.php" class="text-yellow-300 font-bold border-b-2 border-yellow-300">Voir Réservations</a>
                <a href="logout.php" class="bg-red-600 px-3 py-1 rounded hover:bg-red-700 text-sm">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6"><i class="fas fa-list-alt mr-2"></i>Liste des Réservations</h2>

        <!-- Filtre rapide -->
        <div class="flex gap-4 mb-6">
            <select class="border p-2 rounded w-64 bg-white">
                <option>Toutes mes visites</option>
                <option>Safari Nocturne (25 Jan)</option>
                <option>Les Oiseaux Exotiques (28 Jan)</option>
            </select>
            <button class="bg-blue-600 text-white px-4 py-2 rounded shadow">Filtrer</button>
        </div>

        <!-- Tableau des réservations -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-bold">
                    <tr>
                        <th class="p-4">Visiteur</th>
                        <th class="p-4">Visite Réservée</th>
                        <th class="p-4">Date Visite</th>
                        <th class="p-4 text-center">Nombre Pers.</th>
                        <th class="p-4">Date de Réservation</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    
                    <!-- Ligne 1 -->
                    <tr class="hover:bg-blue-50 transition">
                        <td class="p-4 font-bold text-gray-800">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-blue-200 flex items-center justify-center text-blue-800 text-xs">AL</div>
                                Amine Lahlou
                            </div>
                        </td>
                        <td class="p-4">Safari Nocturne</td>
                        <td class="p-4">25 Jan 2025 - 20:00</td>
                        <td class="p-4 text-center"><span class="bg-gray-200 px-2 py-1 rounded font-bold">3</span></td>
                        <td class="p-4 text-sm text-gray-500">12 Jan 2025</td>
                    </tr>

                    <!-- Ligne 2 -->
                    <tr class="hover:bg-blue-50 transition">
                        <td class="p-4 font-bold text-gray-800">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-pink-200 flex items-center justify-center text-pink-800 text-xs">SB</div>
                                Sarah Bennani
                            </div>
                        </td>
                        <td class="p-4">Safari Nocturne</td>
                        <td class="p-4">25 Jan 2025 - 20:00</td>
                        <td class="p-4 text-center"><span class="bg-gray-200 px-2 py-1 rounded font-bold">1</span></td>
                        <td class="p-4 text-sm text-gray-500">14 Jan 2025</td>
                    </tr>

                    <!-- Ligne 3 -->
                    <tr class="hover:bg-blue-50 transition">
                        <td class="p-4 font-bold text-gray-800">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-green-200 flex items-center justify-center text-green-800 text-xs">JD</div>
                                John Doe
                            </div>
                        </td>
                        <td class="p-4">Oiseaux Exotiques</td>
                        <td class="p-4">28 Jan 2025 - 14:00</td>
                        <td class="p-4 text-center"><span class="bg-gray-200 px-2 py-1 rounded font-bold">2</span></td>
                        <td class="p-4 text-sm text-gray-500">15 Jan 2025</td>
                    </tr>

                </tbody>
            </table>
            
            <!-- Footer Tableau -->
            <div class="bg-gray-50 p-3 border-t text-sm text-gray-500 flex justify-between">
                <span>Total: 3 réservations</span>
                <div class="space-x-2">
                    <button class="hover:underline">Précédent</button>
                    <button class="font-bold text-blue-600">1</button>
                    <button class="hover:underline">Suivant</button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>