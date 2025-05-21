<?php
require_once 'db.php';
$id = $_GET['id'] ?? null;
$success = false;

if ($id) {
    // Récupérer les infos du produit
    $stmt = $conn->prepare("SELECT * FROM produits WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();

    // Si formulaire soumis, faire la mise à jour
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nom = $_POST['nom'];
        $desc = $_POST['desc'];
        $categorie = $_POST['categorie'];
        $img = $_POST['img'];
        $prix = $_POST['prix'];

        $stmt = $conn->prepare("UPDATE produits SET nom=?, description=?, categorie=?, img=?, prix=? WHERE id=?");
        $stmt->bind_param("ssssdi", $nom, $desc, $categorie, $img, $prix, $id);
        if ($stmt->execute()) {
            $success = true;
            // Refresh data for display
            $product = [
                'nom' => $nom,
                'description' => $desc,
                'categorie' => $categorie,
                'img' => $img,
                'prix' => $prix
            ];
        }
    }
} else {
    header('Location: produits.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Modifier un produit</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      background: #fafafa;
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .content-container {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding-top: 60px;
    }
    .dashboard-card {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 8px 40px rgba(44,62,80,0.09);
      padding: 40px 32px;
      width: 100%;
      max-width: 540px;
      margin: 40px auto;
      display: flex;
      flex-direction: column;
      gap: 24px;
    }
    .dashboard-card h1 {
      text-align: center;
      color: #232f3e;
      font-size: 2.2rem;
      margin-bottom: 24px;
      font-weight: 700;
    }
    form {
      display: flex;
      flex-direction: column;
      gap: 16px;
    }
    input[type="text"], input[type="number"] {
      padding: 14px 15px;
      font-size: 17px;
      border: 1px solid #ccc;
      border-radius: 8px;
      transition: border 0.3s;
      background: #f7f7f7;
    }
    input[type="text"]:focus, input[type="number"]:focus {
      border-color: #ff9900;
      outline: none;
      background: #fffbe7;
    }
    input[type="submit"] {
      background: #ff9900;
      color: white;
      border: none;
      padding: 14px 0;
      font-size: 19px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      margin-top: 10px;
      transition: background 0.2s;
    }
    input[type="submit"]:hover {
      background: #faad45;
    }
    .success-alert {
      margin: 0 auto 12px auto;
      max-width: 400px;
      background-color: #d5f5e3;
      border-left: 8px solid #28a745;
      border-radius: 8px;
      color: #186a3b;
      font-size: 18px;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 12px;
      box-shadow: 0 2px 12px rgba(34, 49, 63, 0.05);
      padding: 16px 20px;
      animation: slideFadeIn 0.7s cubic-bezier(0.39, 0.575, 0.565, 1) forwards;
    }
    .success-alert .icon { font-size: 26px; }
    @keyframes slideFadeIn {
      0% { transform: translateY(-20px); opacity: 0; }
      100% { transform: translateY(0); opacity: 1; }
    }
    @media (max-width: 700px) {
      .dashboard-card { padding: 25px 5px; }
    }
  </style>
</head>
<body>
    <div class="top-bar">
        <img src="logo.png" alt="Logo" class="logo-img">
        <div><strong>Administration</strong> - Modifier un Produit</div>
        <div><a href="produits.php" style="color:white; text-decoration:none;">Retour</a></div>
    </div>
    <div class="content-container">
        <div class="dashboard-card">
            <h1>Modifier un produit</h1>
            <?php if ($success): ?>
                <div class="success-alert"><span class="icon">✅</span> Modifications enregistrées !</div>
            <?php endif; ?>
            <form method="post">
                <input type="text" name="nom" value="<?= htmlspecialchars($product['nom']) ?>" placeholder="Nom du produit" required>
                <input type="text" name="desc" value="<?= htmlspecialchars($product['description']) ?>" placeholder="Description" required>
                <input type="text" name="categorie" value="<?= htmlspecialchars($product['categorie']) ?>" placeholder="Catégorie" required>
                <input type="text" name="img" value="<?= htmlspecialchars($product['img']) ?>" placeholder="Lien de l'image" required>
                <input type="number" name="prix" value="<?= htmlspecialchars($product['prix']) ?>" placeholder="Prix (DH)" min="1" required>
                <input type="submit" value="Enregistrer les modifications">
            </form>
        </div>
    </div>

<script>
  setTimeout(() => {
    const alert = document.querySelector('.success-alert');
    if(alert) alert.style.display = 'none';
  }, 2500);
</script>
</body>
</html>
