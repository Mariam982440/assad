<?php
session_start();
require 'db.php'; 

$message = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- inscription ---
    if (isset($_POST['btn_register'])) {
        // on récupère les données du formulaire HTML
        $nom = mysqli_real_escape_string($conn, $_POST['nom']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password'];
        $role = mysqli_real_escape_string($conn, $_POST['role']);

        // 1. vérifier si l'email existe déjà
        $check_query = "SELECT id_usr FROM utilisateur WHERE email_usr = '$email'";
        $result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($result) > 0) {
            $message = "<div class='bg-red-100 text-red-700 p-3 rounded mb-4'>Cet email est déjà utilisé.</div>";
        } else {
            // 2. hashage du mot de passe
            $hash = password_hash($password, PASSWORD_DEFAULT);
            
            // 3. insertion 
            $sql = "INSERT INTO utilisateur (nom_usr, email_usr, role_usr, motdepasse_hash) 
                    VALUES ('$nom', '$email', '$role', '$hash')";
            
            if (mysqli_query($conn, $sql)) {
                $message = "<div class='bg-green-100 text-green-700 p-3 rounded mb-4'>Compte créé avec succès ! Connectez-vous.</div>";
            } else {
                $message = "Erreur SQL : " . mysqli_error($conn);
            }
        }
    }

    // --- connexion ---
    if (isset($_POST['btn_login'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password'];

        // 1. chercher l'utilisateur par son email (Colonne : email_usr)
        $sql = "SELECT * FROM utilisateur WHERE email_usr = '$email'";
        $result = mysqli_query($conn, $sql);

        if ($row = mysqli_fetch_assoc($result)) {
            // 2. vérification du mot de passe
            if (password_verify($password, $row['motdepasse_hash'])) {
                
                // 3. création de la session (Mapping des colonnes _usr)
                $_SESSION['user_id'] = $row['id_usr'];
                $_SESSION['nom'] = $row['nom_usr'];
                $_SESSION['role'] = $row['role_usr'];

                // 4. redirection selon le rôle
                if ($row['role_usr'] == 'admin') {
                    header("Location: assad.php");
                } elseif ($row['role_usr'] == 'guide') {
                    header("Location: assad.php");
                } else {
                    // visiteur
                    header("Location: assad.php"); 
                }
                exit();
            } else {
                $message = "<div class='bg-red-100 text-red-700 p-3 rounded mb-4'>Mot de passe incorrect.</div>";
            }
        } else {
            $message = "<div class='bg-red-100 text-red-700 p-3 rounded mb-4'>Aucun compte trouvé.</div>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - ASSAD Zoo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function showRegister() {
            document.getElementById('login-form').classList.add('hidden');
            document.getElementById('register-form').classList.remove('hidden');
        }
        function showLogin() {
            document.getElementById('register-form').classList.add('hidden');
            document.getElementById('login-form').classList.remove('hidden');
        }
    </script>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center" style="background-image: url('https://images.unsplash.com/photo-1546182990-dffeafbe841d?w=1950'); background-size: cover;">

    <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-md opacity-95">
        <h2 class="text-3xl font-bold text-center text-red-700 mb-2">ASSAD ZOO</h2>
        <p class="text-center text-gray-500 mb-6">Espace Membre</p>

        <?= $message; ?>

        <!-- LOGIN -->
        <div id="login-form">
            <h3 class="text-xl font-bold mb-4">Connexion</h3>
            <form action="login.php" method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700">Email</label>
                    <input type="email" name="email" required class="w-full border p-2 rounded">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700">Mot de passe</label>
                    <input type="password" name="password" required class="w-full border p-2 rounded">
                </div>
                <button type="submit" name="btn_login" class="w-full bg-green-800 text-white py-2 rounded font-bold">Se connecter</button>
            </form>
            <p class="mt-4 text-sm text-center">Pas de compte ? <button onclick="showRegister()" class="text-blue-600 font-bold">Créer un compte</button></p>
        </div>

        <!-- INSCRIPTION -->
        <div id="register-form" class="hidden">
            <h3 class="text-xl font-bold mb-4">Inscription</h3>
            <form action="login.php" method="POST">
                <div class="mb-3">
                    <label class="block text-gray-700">Nom complet</label>
                    <!-- name="nom" correspond à $nom en PHP, .... nom_usr -->
                    <input type="text" name="nom" required class="w-full border p-2 rounded">
                </div>
                <div class="mb-3">
                    <label class="block text-gray-700">Email</label>
                    <input type="email" name="email" required class="w-full border p-2 rounded">
                </div>
                <div class="mb-3">
                    <label class="block text-gray-700">Mot de passe</label>
                    <input type="password" name="password" required class="w-full border p-2 rounded">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700">Rôle</label>
                    <select name="role" class="w-full border p-2 rounded">
                        <option value="visiteur">Visiteur</option>
                        <option value="guide">Guide</option>
                    </select>
                </div>
                <button type="submit" name="btn_register" class="w-full bg-yellow-500 text-white py-2 rounded font-bold">S'inscrire</button>
            </form>
            <p class="mt-4 text-sm text-center">Déjà inscrit ? <button onclick="showLogin()" class="text-blue-600 font-bold">Se connecter</button></p>
        </div>
    </div>
</body>
</html>