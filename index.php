<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ASSAD - Zoo Virtuel CAN 2025</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&family=Open+Sans&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Open Sans', sans-serif; }
        h1, h2, h3, .brand-font { font-family: 'Montserrat', sans-serif; }
        
        /* Animation de défilement pour l'arrière-plan */
        .hero-bg {
            background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1546182990-dffeafbe841d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- NAVIGATION (Transparente) -->
    <nav class="absolute top-0 w-full z-50 text-white py-6">
        <div class="container mx-auto px-6 flex justify-between items-center">
            <div class="text-3xl font-black tracking-widest brand-font flex items-center gap-2">
                <i class="fas fa-paw text-yellow-500"></i> ASSAD
            </div>
            <div>
                <!-- Lien vers la page de connexion que nous avons créée avant -->
                <a href="login.php" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-full transition transform hover:scale-105 shadow-lg border-2 border-red-600 hover:border-red-500">
                    <i class="fas fa-sign-in-alt mr-2"></i> Espace Membre
                </a>
            </div>
        </div>
    </nav>

    <!-- SECTION HERO (Plein écran) -->
    <header class="hero-bg h-screen flex items-center justify-center text-center text-white px-6">
        <div class="max-w-4xl mx-auto animate-fade-in-up">
            <div class="inline-block bg-yellow-500 text-black font-bold px-4 py-1 rounded-full mb-6 text-sm uppercase tracking-wide">
                Coupe d'Afrique des Nations 2025 • Maroc
            </div>
            <h1 class="text-5xl md:text-7xl font-black mb-6 leading-tight drop-shadow-2xl">
                L'Esprit des Lions <br> <span class="text-red-600">Virtuels</span>
            </h1>
            <p class="text-xl md:text-2xl mb-10 text-gray-200 font-light">
                Découvrez la faune africaine et rencontrez <strong class="text-yellow-400">Asaad</strong>, le Lion de l'Atlas, entre deux matchs de football.
            </p>
            
            <div class="flex flex-col md:flex-row gap-4 justify-center">
                <a href="login.php" class="bg-red-600 text-white px-8 py-4 rounded-lg text-lg font-bold hover:bg-red-700 transition shadow-lg">
                    Rejoindre l'aventure
                </a>
                <a href="#features" class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-lg text-lg font-bold hover:bg-white hover:text-black transition">
                    En savoir plus
                </a>
            </div>
        </div>
    </header>

    <!-- SECTION FONCTIONNALITÉS -->
    <section id="features" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-green-900 mb-4">Pourquoi visiter ASSAD ?</h2>
                <div class="w-24 h-1 bg-red-600 mx-auto rounded"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Card 1 -->
                <div class="text-center p-8 bg-gray-50 rounded-xl hover:shadow-xl transition border-t-4 border-yellow-500 group">
                    <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-yellow-500 transition">
                        <i class="fas fa-crown text-3xl text-yellow-600 group-hover:text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Rencontrez Asaad</h3>
                    <p class="text-gray-600">Explorez la fiche détaillée de notre mascotte, le Lion de l'Atlas, symbole de fierté nationale.</p>
                </div>

                <!-- Card 2 -->
                <div class="text-center p-8 bg-gray-50 rounded-xl hover:shadow-xl transition border-t-4 border-green-600 group">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-green-600 transition">
                        <i class="fas fa-globe-africa text-3xl text-green-700 group-hover:text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Safari Virtuel</h3>
                    <p class="text-gray-600">Participez à des visites guidées interactives créées par nos guides experts à travers l'Afrique.</p>
                </div>

                <!-- Card 3 -->
                <div class="text-center p-8 bg-gray-50 rounded-xl hover:shadow-xl transition border-t-4 border-red-600 group">
                    <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-red-600 transition">
                        <i class="fas fa-futbol text-3xl text-red-600 group-hover:text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-4">Ambiance CAN</h3>
                    <p class="text-gray-600">Un projet conçu spécialement pour les supporters et les familles durant la compétition.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION APERÇU ANIMAUX -->
    <section class="py-20 bg-green-900 text-white relative overflow-hidden">
        <!-- Motif de fond décoratif -->
        <i class="fas fa-paw absolute top-10 left-10 text-9xl text-white opacity-5 rotate-45"></i>
        <i class="fas fa-leaf absolute bottom-10 right-10 text-9xl text-white opacity-5 -rotate-12"></i>

        <div class="container mx-auto px-6 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-10 md:mb-0">
                <h2 class="text-4xl font-bold mb-6">Une Biodiversité Incroyable</h2>
                <p class="text-lg text-green-100 mb-8 leading-relaxed">
                    Des savanes du Kenya aux montagnes de l'Atlas marocain, notre catalogue interactif recense les espèces les plus emblématiques du continent. Filtrez par habitat, apprenez leur histoire et participez à leur conservation.
                </p>
                <a href="login.php" class="inline-block bg-yellow-500 text-black font-bold px-8 py-3 rounded-lg hover:bg-yellow-400 transition">
                    Voir le Catalogue
                </a>
            </div>
            <div class="md:w-1/2 flex gap-4 justify-center">
                <img src="https://images.unsplash.com/photo-1551009175-8a68da93d5f9?w=400" class="rounded-lg shadow-2xl w-40 mt-10 transform -rotate-6 border-4 border-white">
                <img src="https://images.unsplash.com/photo-1534188753412-3e26d0d618d6?w=400" class="rounded-lg shadow-2xl w-40 mb-10 transform rotate-6 border-4 border-white">
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-gray-900 text-gray-400 py-10">
        <div class="container mx-auto px-6 text-center">
            <h4 class="text-white text-2xl font-bold brand-font mb-4">ASSAD ZOO</h4>
            <div class="flex justify-center gap-6 mb-8">
                <a href="#" class="hover:text-white transition"><i class="fab fa-facebook-f fa-lg"></i></a>
                <a href="#" class="hover:text-white transition"><i class="fab fa-instagram fa-lg"></i></a>
                <a href="#" class="hover:text-white transition"><i class="fab fa-twitter fa-lg"></i></a>
            </div>
            <p class="text-sm">© 2025 Projet CAN Maroc - Tous droits réservés.</p>
        </div>
    </footer>

</body>
</html>