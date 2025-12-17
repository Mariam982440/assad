<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - ASSAD Zoo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">

    <div class="bg-white shadow-2xl rounded-2xl overflow-hidden flex max-w-4xl w-full h-[600px]">
        
        <!-- Colonne Image (Décoration) -->
        <div class="hidden md:block w-1/2 bg-cover bg-center relative" style="background-image: url('https://images.unsplash.com/photo-1546182990-dffeafbe841d?w=800');">
            <div class="absolute inset-0 bg-red-900 bg-opacity-40 flex items-center justify-center">
                <div class="text-center text-white p-6">
                    <h1 class="text-4xl font-bold mb-2">ASSAD ZOO</h1>
                    <p class="text-lg">Vivez la CAN 2025 au cœur de la nature.</p>
                </div>
            </div>
        </div>

        <!-- Colonne Formulaire -->
        <div class="w-full md:w-1/2 p-10 overflow-y-auto">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-green-800">Bienvenue</h2>
                <p class="text-gray-500">Connectez-vous ou créez un compte</p>
            </div>

            <!-- Tabs (Simulation JS pour basculer Login/Register) -->
            <div class="flex border-b mb-6">
                <button class="w-1/2 py-2 border-b-2 border-red-600 text-red-600 font-bold">Connexion</button>
                <button class="w-1/2 py-2 text-gray-500 hover:text-red-600">Inscription</button>
            </div>

            <!-- Formulaire Connexion -->
            <form action="asaad.html" method="POST" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" class="w-full border p-2 rounded focus:ring-2 focus:ring-green-600 focus:outline-none" placeholder="nom@exemple.com">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Mot de passe</label>
                    <input type="password" class="w-full border p-2 rounded focus:ring-2 focus:ring-green-600 focus:outline-none">
                </div>
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center">
                        <input type="checkbox" class="mr-2"> Se souvenir de moi
                    </label>
                    <a href="#" class="text-red-600 hover:underline">Mdp oublié ?</a>
                </div>
                <button type="submit" class="w-full bg-green-800 text-white py-3 rounded-lg font-bold hover:bg-green-900 transition">
                    Se connecter
                </button>
            </form>

            <!-- Partie Inscription (Masquée visuellement pour l'exemple, à activer via JS ou page séparée) -->
            <div class="mt-8 pt-4 border-t">
                <p class="text-xs text-gray-400 text-center">Pour l'inscription : choisir le rôle (Visiteur ou Guide)</p>
            </div>
        </div>
    </div>

</body>
</html>