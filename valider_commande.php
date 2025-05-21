<?php
session_start();
require_once 'db.php';

// Vérifier si le client est connecté
if (!isset($_SESSION['client_id'])) {
    header('Location: login.php');
    exit();
}

$id_client = $_SESSION['client_id'];

// Charger le panier du client
$sql = "SELECT p.*, pa.quantite FROM panier pa 
        JOIN produits p ON pa.id_produit = p.id 
        WHERE pa.id_client = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_client);
$stmt->execute();
$result = $stmt->get_result();

$panier = [];
$total = 0;
while ($row = $result->fetch_assoc()) {
    $panier[] = $row;
    $total += $row['prix'] * $row['quantite'];
}

// Traitement du formulaire de commande
$commande_success = false;
$error = '';
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['paiement'])) {
    $mode_paiement = $_POST['paiement'];

    // Créer la commande (insertion dans la table commandes)
    $stmt = $conn->prepare(
        "INSERT INTO commandes (id_client, total, mode_paiement) VALUES (?, ?, ?)"
    );
    $stmt->bind_param("ids", $id_client, $total, $mode_paiement);  // "i"nt, "d"ouble, "s"tring
    if ($stmt->execute()) {
        $id_commande = $stmt->insert_id;
    
        // 🔽 Ajoute ce bloc ici
        foreach ($panier as $article) {
            $stmt = $conn->prepare("INSERT INTO commande_produits (id_commande, id_produit, quantite, prix) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiid", $id_commande, $article['id'], $article['quantite'], $article['prix']);
            $stmt->execute();
        }
    
        // Vider le panier
        $conn->query("DELETE FROM panier WHERE id_client = $id_client");
        $commande_success = true;
    }
     else {
        $error = "Erreur lors de l'enregistrement de la commande.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Finaliser ma commande</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .commande-card { background: #fff; border-radius: 12px; max-width: 600px; margin: 200px auto; padding: 36px; box-shadow: 0 8px 40px rgba(44,62,80,0.09);}
        .commande-card h2 { text-align:center; color: #232f3e;}
        .panier-item { display: flex; gap: 20px; align-items:center; padding:12px 0; border-bottom:1px solid #eee;}
        .panier-item:last-child {border-bottom: none;}
        .prix {color:#B12704;font-weight:bold;}
        .paiement {margin: 20px 0;}
        .historique-link { display:block; text-align:center; margin:30px 0 10px 0; color: #FF9900;}
        .success { background:#d5f5e3; color:#186a3b; padding:12px 18px; border-radius:8px; text-align:center; font-weight:bold;}
        .error { background:#ffcccc; color:#900; padding:12px 18px; border-radius:8px; text-align:center; font-weight:bold;}
    </style>
</head>
<body>
    <?php include 'bar.php'; ?>
    <div class="commande-card">
        <h2>Finaliser ma commande</h2>

        <?php if ($commande_success): ?>
            <div class="success">Votre commande a été enregistrée avec succès !</div>
            <a href="commandes.php" class="historique-link">Voir mon historique de commandes</a>
        <?php elseif ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (!$commande_success): ?>
        <!-- Afficher le panier -->
        <h3>Résumé de votre panier :</h3>
        <?php foreach ($panier as $article): ?>
            <div class="panier-item">
                <span><?= htmlspecialchars($article['nom']) ?> (x<?= $article['quantite'] ?>)</span>
                <span class="prix"><?= number_format($article['prix'],2) ?> DH</span>
            </div>
        <?php endforeach; ?>
        <div style="text-align:right;margin-top:12px;">
            <strong>Total : <?= number_format($total,2) ?> DH</strong>
        </div>
        <!-- Choix paiement -->
        <form method="post" class="paiement">
            <label><input type="radio" name="paiement" value="livraison" required> Paiement à la livraison</label>
            <label><input type="radio" name="paiement" value="carte" required> Carte bancaire</label>
            <button type="submit" style="margin-top: 16px; background:#FF9900;color:white; border:none;padding:10px 22px; border-radius:6px;font-size:17px;cursor:pointer;">Valider la commande</button>
        </form>
        <?php endif; ?>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
