<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Asaad - Le Lion de l'Atlas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">

    <!-- NAVBAR COMMUNE -->
    <nav class="bg-green-800 text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="text-xl font-bold flex items-center gap-2">
                <i class="fas fa-paw text-yellow-400"></i> ASSAD ZOO
            </div>
            <!-- Menu Simulé (Selon le rôle, tu afficheras certains liens avec PHP) -->
            <div class="hidden md:flex space-x-6">
                <a href="asaad.html" class="text-yellow-300 font-bold border-b-2 border-yellow-300">Le Lion Asaad</a>
                <a href="visitor_catalog.html" class="hover:text-yellow-200">Animaux</a>
                <a href="admin_panel.html" class="hover:text-yellow-200">Espace Admin (Test)</a>
                <a href="guide_panel.html" class="hover:text-yellow-200">Espace Guide (Test)</a>
            </div>
            <a href="login.html" class="bg-red-600 px-4 py-2 rounded hover:bg-red-700 transition">Déconnexion</a>
        </div>
    </nav>

    <!-- HEADER HERO -->
    <header class="relative h-[500px] flex items-center justify-center text-white bg-fixed bg-cover bg-center" 
        style="background-image: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1614027164847-1b28cfe1df60?w=1200');">
        <div class="text-center">
            <h1 class="text-6xl font-bold mb-4 drop-shadow-lg">ASAAD</h1>
            <p class="text-2xl text-yellow-400 font-semibold tracking-wide">L'âme de l'Atlas - Symbole de la CAN 2025</p>
        </div>
    </header>

    <!-- CONTENU FICHE -->
    <section class="container mx-auto px-6 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            
            <!-- Description -->
            <div>
                <h2 class="text-3xl font-bold text-red-700 mb-6 border-l-4 border-green-800 pl-4">Son Histoire</h2>
                <p class="text-gray-700 text-lg leading-relaxed mb-6">
                    Asaad est le descendant direct des lions de Barbarie qui peuplaient autrefois les montagnes du Maroc. 
                    Symbole de force et de noblesse, il a été choisi comme mascotte vivante de notre zoo virtuel pour célébrer 
                    l'accueil de la Coupe d'Afrique des Nations.
                </p>
                
                <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-yellow-500">
                    <h3 class="font-bold text-xl mb-4 text-gray-800"><i class="fas fa-info-circle mr-2"></i>Fiche Technique</h3>
                    <ul class="space-y-2">
                        <li class="flex justify-between border-b pb-2"><span>Nom scientifique :</span> <span class="font-bold">Panthera leo leo</span></li>
                        <li class="flex justify-between border-b pb-2"><span>Âge :</span> <span class="font-bold">6 ans</span></li>
                        <li class="flex justify-between border-b pb-2"><span>Habitat :</span> <span class="font-bold">Montagnes (Simulé)</span></li>
                        <li class="flex justify-between"><span>Alimentation :</span> <span class="font-bold">Carnivore</span></li>
                    </ul>
                </div>
            </div>

            <!-- Galerie -->
            <div class="grid grid-cols-2 gap-4">
                <img src="https://images.unsplash.com/photo-1511216335778-7cb8f49fa7a3?w=500" class="rounded-lg shadow-lg hover:scale-105 transition transform duration-300">
                <img src="https://images.unsplash.com/photo-1549480017-d76466a4b7e8?w=500" class="rounded-lg shadow-lg hover:scale-105 transition transform duration-300 mt-8">
                <img src="https://images.unsplash.com/photo-1575550959106-5a7defe28b56?w=500" class="rounded-lg shadow-lg hover:scale-105 transition transform duration-300">
                <img src="https://images.unsplash.com/photo-1534188753412-3e26d0d618d6?w=500" class="rounded-lg shadow-lg hover:scale-105 transition transform duration-300 mt-8">
            </div>
        </div>
    </section>

</body>
</html>