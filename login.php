<?php
session_start();
require 'db.php'; 

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // inscription
    if (isset($_POST['btn_register'])) {
        $nom = mysqli_real_escape_string($conn, $_POST['nom']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password'];
        $role = mysqli_real_escape_string($conn, $_POST['role']);

        // vérifier si l'email existe déjà
        $check_query = "SELECT id_usr FROM utilisateur WHERE email_usr = '$email'";
        $result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($result) > 0) {
            $message = "<div class='bg-red-100 text-red-700 p-3 rounded mb-4'>Cet email est déjà utilisé.</div>";
        } else {
            // hashage
            $hash = password_hash($password, PASSWORD_DEFAULT);
            
            
            // si c'est un guide non approuvé sinon approuvé direct
            $est_approuve = ($role == 'guide') ? 0 : 1;

            // insertion avec la colonne est_approuve
            $sql = "INSERT INTO utilisateur (nom_usr, email_usr, role_usr, motdepasse_hash, est_approuve) 
                    VALUES ('$nom', '$email', '$role', '$hash', '$est_approuve')";
            
            if (mysqli_query($conn, $sql)) {
                // message personnalisé selon le rôle
                if ($role == 'guide') {
                    $message = "<div class='bg-blue-100 text-blue-700 p-3 rounded mb-4'>Compte Guide créé ! <b>En attente de validation par l'administrateur.</b></div>";
                } else {
                    $message = "<div class='bg-green-100 text-green-700 p-3 rounded mb-4'>Compte créé avec succès ! Connectez-vous.</div>";
                }
            } else {
                $message = "Erreur SQL ";
            }
        }
    }

    // connexion
    if (isset($_POST['btn_login'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = $_POST['password'];

        $sql = "SELECT * FROM utilisateur WHERE email_usr = '$email'";
        $result = mysqli_query($conn, $sql);

        if ($row = mysqli_fetch_assoc($result)) {
            // vérification mot de passe
            if (password_verify($password, $row['motdepasse_hash'])) {
                
                
                if ($row['role_usr'] == 'guide' && $row['est_approuve'] == 0) {
                    $message = "<div class='bg-yellow-100 text-yellow-800 p-3 rounded mb-4'>🚫 Votre compte Guide n'a pas encore été approuvé par l'administrateur.</div>";
                } else {
                    
                    $_SESSION['user_id'] = $row['id_usr'];
                    $_SESSION['nom'] = $row['nom_usr'];
                    $_SESSION['role'] = $row['role_usr'];

                    header("Location: assad.php");
                    exit();
                }

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
                <button type="submit" name="btn_login" class="w-full bg-green-800 text-white py-2 rounded font-bold hover:bg-green-900">Se connecter</button>
            </form>
            <p class="mt-4 text-sm text-center">Pas de compte ? <button onclick="showRegister()" class="text-blue-600 font-bold hover:underline">Créer un compte</button></p>
        </div>

        <!-- INSCRIPTION -->
        <div id="register-form" class="hidden">
            <h3 class="text-xl font-bold mb-4">Inscription</h3>
            <form action="login.php" method="POST">
                <div class="mb-3">
                    <label class="block text-gray-700">Nom complet</label>
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
                    <select name="role" class="w-full border p-2 rounded bg-white">
                        <option value="visiteur">Visiteur</option>
                        <option value="guide">Guide</option>
                    </select>
                </div>
                <button type="submit" name="btn_register" class="w-full bg-yellow-500 text-white py-2 rounded font-bold hover:bg-yellow-600">S'inscrire</button>
            </form>
            <p class="mt-4 text-sm text-center">Déjà inscrit ? <button onclick="showLogin()" class="text-blue-600 font-bold hover:underline">Se connecter</button></p>
        </div>
    </div>
</body>
</html>