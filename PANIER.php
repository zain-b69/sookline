<?php
require_once 'db.php';
session_start();
$panier = [];
$id_client = $_SESSION['client_id'] ?? null;
if ($id_client) {
    $sql = "SELECT p.*, pa.quantite FROM panier pa JOIN produits p ON pa.id_produit = p.id WHERE pa.id_client = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_client);
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()) {
        $panier[$row['id']] = [
            'nom' => $row['nom'],
            'prix' => $row['prix'],
            'quantite' => $row['quantite'],
            'img' => $row['img'],
            'description' => $row['description'],
            'categorie' => $row['categorie']
        ];
    }
}

$sql = "SELECT p.nom, p.description, p.img, p.prix FROM produits p LIMIT 5";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Panier - SookLine</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <style>
    .main-content {
      display: flex;
      justify-content: center;
      gap: 40px;
      margin: 50px auto 0 auto;
      max-width: 1100px;
      align-items: flex-start;
    }
    .panier-container, .hero-news {
      background: #fff;
      border-radius: 14px;
      box-shadow: 0 4px 24px rgba(44,62,80,0.09);
      padding: 30px;
      min-width: 340px;
    }
    .panier-container {
      flex: 2;
    }
    .hero-news {
      flex: 1;
      max-width: 340px;
    }
    @media (max-width: 900px) {
      .main-content {
        flex-direction: column;
        gap: 24px;
        align-items: center;
      }
      .hero-news, .panier-container {
        min-width: 90vw;
        max-width: 98vw;
      }
    }
  </style>
</head>
<body>
<?php include 'bar.php'; ?>

<div class="main-content">
  <!-- Panier à gauche -->
  <div class="panier-container">
    <?php
    $total = 0;
    if (empty($panier)): ?>
      <p style="padding: 20px; color: #232F3E;">Votre panier est vide.</p>
    <?php else: ?>
      <?php foreach ($panier as $id => $article):
        $sousTotal = $article['prix'] * $article['quantite'];
        $total += $sousTotal;
      ?>
      <div class="panier-item" style="display: flex; gap: 20px; margin-bottom: 25px; align-items: center;">
        <div class="img-box">
          <?php if (!empty($article['img'])): ?>
            <img src="img/<?= htmlspecialchars($article['img']) ?>" alt="<?= htmlspecialchars($article['nom']) ?>" style="width: 100px; border-radius: 8px;">
          <?php else: ?>
            <img src="img/default.png" alt="Image par défaut" style="width: 100px; border-radius: 8px;">
          <?php endif; ?>
        </div>
        <div class="details-box" style="flex:1;">
          <h3><?= htmlspecialchars($article['nom'] ?? '-') ?></h3>
          <p>
            <?php if (!empty($article['description'])): ?>
              <?= htmlspecialchars($article['description']) ?>
            <?php else: ?>
              <span style="color:#999;">Aucune description</span>
            <?php endif; ?>
          </p>
          <span class="categorie"><?= htmlspecialchars($article['categorie'] ?? '-') ?></span>
          <br>
          <span class="quantite">
              Quantité :
              <form method="post" action="modifier_quantite.php" style="display:inline;">
                  <input type="hidden" name="id_produit" value="<?= $id ?>">
                  <input type="number" name="quantite" value="<?= $article['quantite'] ?>" min="1" style="width:50px;">
                  <button type="submit" style="background-color:#febd69; border:none; color:#232F3E; padding:4px 10px; border-radius:5px;">✔</button>
              </form>
          </span>
        </div>
        <div class="action-box" style="min-width: 100px; text-align: center;">
          <div class="prix"><?= number_format($article['prix'], 2) ?> DH</div>
          <a href="supprimer_panier.php?id=<?= $id ?>" class="delete-btn">Supprimer</a>
        </div>
      </div>
      <?php endforeach; ?>
      <div class="panier-total">
  <div class="prix">Total : <?= number_format($total, 2) ?> DH</div>
  <div style=" display: flex; gap: 20px; align-items: flex-end; flex-direction: column-reverse;">
  <a href="#" class="continue-btn" onclick="window.history.back(); return false;">
  Poursuivre les achats
</a>

    <a href="valider_commande.php" class="valider-btn">Passer la commande</a>
  </div>
</div>

    <?php endif; ?>
  </div>

  <!-- Nouveaux achats à droite -->
  <div class="hero-news">
      <h2 style="font-size: 18px; margin-bottom: 15px;">New customers purchased</h2>
      <?php if ($result && $result->num_rows > 0): ?>
          <?php while($row = $result->fetch_assoc()): ?>
              <div class="product-card" style="margin-top: 15px;">
                  <img src="img/<?= htmlspecialchars($row['img']) ?>" alt="<?= htmlspecialchars($row['nom']) ?>" style="max-width: 80px;">
                  <h3><?= htmlspecialchars($row['nom']) ?></h3>
                  <p><?= htmlspecialchars($row['description']) ?></p>
                  <div class="price"><?= number_format($row['prix'], 2) ?> DH</div>
              </div>
          <?php endwhile; ?>
      <?php else: ?>
          <p>Aucun achat récent.</p>
      <?php endif; ?>
      <a href="recherche.php" class="voir-plus-btn" style="display: block; width: 150px; margin: 30px auto 0 auto; padding: 10px 0; background: #FF9900; color: white; border-radius: 8px; text-align: center; font-weight: bold; text-decoration: none;">
    Voir plus
</a>

  </div>
</div>

<!-- SCROLL TO TOP BUTTON -->
<div style="text-align: center; padding: 20px; background-color: #37475a;">
  <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" 
          style="padding: 10px 20px; background-color: #232f3e; color: white; border: none; cursor: pointer; border-radius: 4px;">
    Retour en haut
  </button>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
