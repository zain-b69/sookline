<?php
require_once 'db.php';
session_start();

// Sécurité : vérifie si c'est un administrateur
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Utilise prepare() pour éviter l'injection
    $stmt1 = $conn->prepare("DELETE FROM panier WHERE id_produit = ?");
    $stmt1->bind_param("i", $id);
    $stmt1->execute();

    $stmt2 = $conn->prepare("DELETE FROM produits WHERE id = ?");
    $stmt2->bind_param("i", $id);
    $stmt2->execute();
}

header("Location: produits.php");
exit();
?>
