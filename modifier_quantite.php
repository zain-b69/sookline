<?php
session_start();
require_once 'db.php';

$id_client = $_SESSION['client_id']; // l'id du client connecté
$id_produit = intval($_POST['id_produit']);
$quantite = max(1, intval($_POST['quantite']));

// On ne garde jamais une quantité négative ou nulle
if ($quantite < 1) $quantite = 1;

$sql = "UPDATE panier SET quantite = ? WHERE id_client = ? AND id_produit = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $quantite, $id_client, $id_produit);
$stmt->execute();

header('Location: panier.php');
exit;
?>
