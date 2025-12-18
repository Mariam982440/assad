<?php
session_start();
require '../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    die("Accès interdit");
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM animal WHERE id_al = $id";
    mysqli_query($conn, $sql);
}

header("Location: ../asaad.php");
exit();
?>