<?php
session_start();
require '../db.php';

// Sécurité : Guide uniquement
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'guide') {
    die("Accès interdit");
}

if (isset($_GET['id']) ) {
    
    $id_visite = intval($_GET['id']);
    $id_guide = $_SESSION['user_id'];

    // Vérification : On s'assure que la visite appartient bien à ce guide !
    // C'est très important pour qu'un guide ne supprime pas la visite d'un autre.
    $check = mysqli_query($conn, "SELECT id FROM visite_guidee WHERE id = $id_visite AND id_utilisateur = $id_guide");
    
    if (mysqli_num_rows($check) > 0) {
        
        
        // CAS 1 : On ANNULE (Update)
        // On change le statut, mais on garde les données
        $sql = "UPDATE visite_guidee SET statut = 'annulee' WHERE id = $id_visite";
        mysqli_query($conn, $sql);
    }
    
}

// Retour à la liste
header("Location: guide_tours.php");
exit();
?>