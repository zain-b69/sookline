<?php
session_start();
require_once 'db.php';

// Récupérer tous les produits
$sql = "SELECT * FROM produits";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Produits - Admin SOOKLINE</title>
    <link rel="stylesheet" href="styles.css" />
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI&display=swap" rel="stylesheet" />
</head>

<body>
    <div class="admin-layout">
            <!-- Sidebar -->
            <aside class="sidebar">
            <div class="logo">
                <img src="logo.png" alt="Logo Sookline" />
            </div>
            <nav>
                <a href="dashboard.php">Dashboard</a>
                <a href="produits.php" class="active">Produits</a>
                <a href="view_clients.php">Clients</a>
                <a href="logout.php">Déconnexion</a>
            </nav>
        </aside>

        <!-- Contenu principal -->
        <main class="main-content">
            <h2>Gestion des produits</h2> <br>

            <div style="margin-bottom: 20px;">
                <button class="btn-add" onclick="window.location.href='add_product.php'">+ Ajouter un produit</button>
            </div>

            <table class="admin-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Image</th> 
            <th>Nom</th>
            <th>Catégorie</th>
            <th>Prix</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td>
                <?php if (!empty($row['img'])): ?>
                  <img src="img/<?= htmlspecialchars($row['img']) ?>" alt="Produit" style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px;">
                <?php else: ?>
                  <span style="color:#bbb;">Aucune image</span>
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($row['nom']) ?></td>
            <td><?= htmlspecialchars($row['categorie']) ?></td>
            <td><?= number_format($row['prix'], 2) ?> DH</td>
            <td>
                <a class="btn-edit" href="edit_product.php?id=<?= $row['id'] ?>">Modifier</a>
                <a class="btn-delete" href="delete_product.php?id=<?= $row['id'] ?>"
                   onclick="return confirm('Supprimer ce produit ?')">Supprimer</a>
            </td>
        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="6">Aucun produit trouvé.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

        </main>
    </div>
    <?php include 'footer.php'; ?>
</body>


</html>
