<?php
session_start();
require '../db.php'; // Assure-toi que le chemin vers db.php est correct

// 1. SÉCURITÉ : Vérifier si c'est un VISITEUR connecté
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'visiteur') {
    // Si pas connecté, on redirige vers le login
    header("Location: ../login.php");
    exit();
}

// 2. TRAITEMENT DE LA DEMANDE
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book'])) {
    
    // Récupération des données envoyées par le formulaire
    $id_visite = intval($_POST['id_visite']);
    $nb_personnes_demandees = intval($_POST['nb_personnes']);
    $id_user = $_SESSION['user_id'];

    // Petite sécurité : on ne peut pas réserver 0 ou -1 personne
    if ($nb_personnes_demandees <= 0) {
        echo "<script>alert('Nombre de personnes invalide.'); window.history.back();</script>";
        exit();
    }

    // 3. VÉRIFICATION ANTI-SURBOOKING (Crucial !)
    // On doit vérifier en base de données s'il reste de la place MAINTENANT
    
    $sql_check = "SELECT capacite_max, 
                  (SELECT SUM(nbpersonnes) FROM reservations WHERE id_visite = $id_visite) as total_reserve 
                  FROM visite_guidee 
                  WHERE id = $id_visite";

    $result_check = mysqli_query($conn, $sql_check);
    $data = mysqli_fetch_assoc($result_check);

    if (!$data) {
        die("Erreur : Cette visite n'existe plus.");
    }

    $capacite_max = $data['capacite_max'];
    // Si total_reserve est NULL (aucune résa), on met 0
    $places_occupees = $data['total_reserve'] ? $data['total_reserve'] : 0;
    $places_restantes = $capacite_max - $places_occupees;

    // 4. DÉCISION
    if ($nb_personnes_demandees <= $places_restantes) {
        
        // C'est bon, il y a de la place ! On insère.
        $sql_insert = "INSERT INTO reservations (nbpersonnes, id_visite, id_utilisateur) 
                       VALUES ($nb_personnes_demandees, $id_visite, $id_user)";

        if (mysqli_query($conn, $sql_insert)) {
            // SUCCÈS -> Redirection vers le tableau de bord avec un message
            header("Location: reserv_tours.php?success=1");
            exit();
        } else {
            // Erreur technique SQL
            echo "Erreur SQL : " . mysqli_error($conn);
        }

    } else {
        // ÉCHEC : Plus assez de place (ex: il en restait 2, l'utilisateur en voulait 3)
        echo "<script>
                alert('Désolé ! Il ne reste que $places_restantes places disponibles.');
                window.history.back(); // Retour au formulaire
              </script>";
    }

} else {
    // Si on essaie d'ouvrir la page sans cliquer sur "Réserver"
    header("Location: visiteur_tours.php");
    exit();
}
?>