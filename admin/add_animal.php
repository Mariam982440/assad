<?php
session_start();
require '../db.php'; // Attention au chemin ../

// Sécurité Admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    die("Accès interdit");
}

$message = "";

// TRAITEMENT DU FORMULAIRE
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $espece = mysqli_real_escape_string($conn, $_POST['espece']);
    $pays = mysqli_real_escape_string($conn, $_POST['pays']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $habitat = $_POST['habitat']; // C'est un ID (int)

    // Gestion Image
    $imageName = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = time() . "_" . $_FILES['image']['name']; // Renommer pour éviter doublons
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $imageName);
    }

    $sql = "INSERT INTO animal (nom_al, espece, paysorigine, descriptioncourte, id_habitat, image) 
            VALUES ('$nom', '$espece', '$pays', '$desc', '$habitat', '$imageName')";

    if (mysqli_query($conn, $sql)) {
        header("Location: ../animal.php"); // Retour à la liste après succès
        exit();
    } else {
        $message = "Erreur SQL : " . mysqli_error($conn);
    }
}

// Récupérer les habitats pour la liste déroulante
$habitats = mysqli_query($conn, "SELECT * FROM habitatt");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un animal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded shadow-lg w-full max-w-lg">
        <h2 class="text-2xl font-bold mb-6">Ajouter un animal</h2>
        <?= $message ?>
        
        <!-- enctype="multipart/form-data" EST OBLIGATOIRE POUR LES IMAGES -->
        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            <input type="text" name="nom" placeholder="Nom de l'animal" required class="w-full border p-2 rounded">
            <input type="text" name="espece" placeholder="Espèce (ex: Panthera leo)" class="w-full border p-2 rounded">
            <input type="text" name="pays" placeholder="Pays d'origine" class="w-full border p-2 rounded">
            
            <select name="habitat" class="w-full border p-2 rounded">
                <option value="">Choisir un habitat...</option>
                <?php while($h = mysqli_fetch_assoc($habitats)): ?>
                    <option value="<?= $h['id_hab'] ?>"><?= $h['nom_hab'] ?></option>
                <?php endwhile; ?>
            </select>

            <div>
                <label class="block text-sm text-gray-600">Image de l'animal</label>
                <input type="file" name="image" class="w-full border p-2 rounded">
            </div>

            <textarea name="description" placeholder="Description courte" class="w-full border p-2 rounded"></textarea>

            <button type="submit" class="w-full bg-green-600 text-white py-2 rounded font-bold">Enregistrer</button>
            <a href="../animal.php" class="block text-center mt-2 text-gray-500">Annuler</a>
        </form>
    </div>
</body>
</html>