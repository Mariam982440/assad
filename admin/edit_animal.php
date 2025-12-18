<?php
session_start();
require '../db.php'; // On remonte d'un dossier pour trouver db.php

// 1. SÉCURITÉ : Vérifier si c'est un ADMIN
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    die("Accès interdit : Vous n'êtes pas administrateur.");
}

// 2. RÉCUPÉRATION DE L'ANIMAL À MODIFIER
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sécuriser l'ID en entier
    $sql = "SELECT * FROM animal WHERE id_al = $id";
    $result = mysqli_query($conn, $sql);
    $animal = mysqli_fetch_assoc($result);

    if (!$animal) {
        die("Animal introuvable.");
    }
} else {
    header("Location: ../animal.php");
    exit();
}

$message = "";

// 3. TRAITEMENT DU FORMULAIRE (MISE À JOUR)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Récupération et sécurisation des champs texte
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $espece = mysqli_real_escape_string($conn, $_POST['espece']);
    $pays = mysqli_real_escape_string($conn, $_POST['pays']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $habitat_id = intval($_POST['habitat']);

    // Gestion de l'image (Complexe)
    $imagePartSQL = ""; // Par défaut, on ne change pas l'image dans la requête
    
    // Si une nouvelle image a été envoyée
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = time() . "_" . $_FILES['image']['name'];
        $uploadDir = "../uploads/";
        
        // Supprimer l'ancienne image du dossier si elle existe (Optionnel mais propre)
        if (!empty($animal['image']) && file_exists($uploadDir . $animal['image'])) {
            unlink($uploadDir . $animal['image']);
        }

        // Uploader la nouvelle
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName)) {
            // On ajoute ce morceau à la requête SQL
            $imagePartSQL = ", image = '$imageName'";
        }
    }

    // Requête UPDATE
    $sql_update = "UPDATE animal SET 
                   nom_al = '$nom', 
                   espece = '$espece', 
                   paysorigine = '$pays', 
                   descriptioncourte = '$desc', 
                   id_habitat = $habitat_id 
                   $imagePartSQL 
                   WHERE id_al = $id";

    if (mysqli_query($conn, $sql_update)) {
        header("Location: ../animal.php"); // Succès -> Retour accueil
        exit();
    } else {
        $message = "<div class='bg-red-100 text-red-700 p-3 rounded mb-4'>Erreur SQL : " . mysqli_error($conn) . "</div>";
    }
}

// 4. RÉCUPÉRER LA LISTE DES HABITATS (Pour le menu déroulant)
$habitats = mysqli_query($conn, "SELECT * FROM habitatt");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un Animal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen py-10">

    <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-2xl">
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h2 class="text-2xl font-bold text-gray-800">Modifier : <?= htmlspecialchars($animal['nom_al']) ?></h2>
            <a href="../animal.php" class="text-gray-500 hover:text-gray-700"><i class="fas fa-times"></i></a>
        </div>

        <?= $message ?>
        
        <form method="POST" enctype="multipart/form-data" class="space-y-5">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Nom -->
                <div>
                    <label class="block text-gray-700 font-bold mb-1">Nom</label>
                    <input type="text" name="nom" value="<?= htmlspecialchars($animal['nom_al']) ?>" required class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-500">
                </div>
                <!-- Espèce -->
                <div>
                    <label class="block text-gray-700 font-bold mb-1">Espèce</label>
                    <input type="text" name="espece" value="<?= htmlspecialchars($animal['espece']) ?>" class="w-full border p-2 rounded">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Pays -->
                <div>
                    <label class="block text-gray-700 font-bold mb-1">Pays d'origine</label>
                    <input type="text" name="pays" value="<?= htmlspecialchars($animal['paysorigine']) ?>" class="w-full border p-2 rounded">
                </div>
                <!-- Habitat -->
                <div>
                    <label class="block text-gray-700 font-bold mb-1">Habitat</label>
                    <select name="habitat" class="w-full border p-2 rounded bg-white">
                        <?php while($h = mysqli_fetch_assoc($habitats)): ?>
                            <!-- Petite astuce PHP pour sélectionner l'habitat actuel -->
                            <option value="<?= $h['id_hab'] ?>" <?= ($animal['id_habitat'] == $h['id_hab']) ? 'selected' : '' ?>>
                                <?= $h['nom_hab'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>

            <!-- Gestion Image -->
            <div class="border p-4 rounded bg-gray-50 flex gap-4 items-center">
                <div class="w-1/3">
                    <p class="text-xs font-bold mb-2">Image Actuelle :</p>
                    <?php if(!empty($animal['image'])): ?>
                        <img src="../uploads/<?= $animal['image'] ?>" class="w-20 h-20 object-cover rounded border">
                    <?php else: ?>
                        <span class="text-gray-400 text-xs">Aucune image</span>
                    <?php endif; ?>
                </div>
                <div class="w-2/3">
                    <label class="block text-gray-700 font-bold mb-1">Changer l'image (Optionnel)</label>
                    <input type="file" name="image" class="w-full text-sm text-gray-500">
                    <p class="text-xs text-gray-400 mt-1">Laissez vide pour conserver l'image actuelle.</p>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-gray-700 font-bold mb-1">Description courte</label>
                <textarea name="description" rows="4" class="w-full border p-2 rounded"><?= htmlspecialchars($animal['descriptioncourte']) ?></textarea>
            </div>

            <!-- Boutons -->
            <div class="flex gap-4 pt-4">
                <button type="submit" class="flex-1 bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 transition">
                    <i class="fas fa-save mr-2"></i> Enregistrer les modifications
                </button>
                <a href="../animal.php" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg font-bold hover:bg-gray-400">
                    Annuler
                </a>
            </div>

        </form>
    </div>

</body>
</html>