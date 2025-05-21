<?php
session_start();

if (isset($_GET['id'])) {
    // Connexion à la base de données
    $conn = mysqli_connect("localhost", "root", "hello", "sookline");
    if (!$conn) {
        die("Connexion échouée: " . mysqli_connect_error());
    }

    $id = $_GET['id'];

    $sql = "DELETE FROM panier WHERE id_produit = '$id' ";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die("Erreur lors de la suppression du produit du panier: " . mysqli_error($conn));
    }   

    if (isset($_SESSION['panier'][$id])) {
        unset($_SESSION['panier'][$id]);
    }
}

// Après suppression, on retourne au panier
header("Location: panier.php");
exit();

?>