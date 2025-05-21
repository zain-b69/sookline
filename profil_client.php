<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Profil Client - SOOKLINE</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

<?php
include 'bar.php';
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
require_once 'db.php';

$id_client = $_SESSION['client_id'] ?? null;
$client = [];

if ($id_client) {
    $stmt = $conn->prepare("SELECT nom, prenom, email, password, adresse FROM clients WHERE id = ?");
    $stmt->bind_param("i", $id_client);
    $stmt->execute();
    $result = $stmt->get_result();
    $client = $result->fetch_assoc();
}
?>

<!-- CONTENU PRINCIPAL -->
<div class="main-container">
  <!-- Colonne gauche -->
  <?php include 'menu_gauche.php'; ?>

  <!-- Contenu droite -->
  <div class="content">
    <h2>Informations de votre compte</h2>
    
    <?php if ($client): ?>
      <p><b>Nom :</b> <?= htmlspecialchars($client['nom']) ?></p>
      <p><b>Prénom :</b> <?= htmlspecialchars($client['prenom']) ?></p>
      <p><b>Email :</b> <?= htmlspecialchars($client['email']) ?></p>
      <p><b>Adresse :</b> <?= htmlspecialchars($client['adresse'] ?? 'Non renseignée') ?></p>
    <?php else: ?>
      <p>Impossible de charger les informations du client.</p>
    <?php endif; ?>

  </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
