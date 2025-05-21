<?php
// Connexion à la base de données
require 'db.php'; 
session_start();
 
// Suppression d'un client si demandé
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);
	$conn->query("DELETE FROM panier WHERE id_client = $id");
    $conn->query("DELETE FROM clients WHERE id = $id");
}

// Récupération des clients
$sql = "SELECT * FROM clients";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Clients - Admin SOOKLINE</title>
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
                <a href="produits.php">Produits</a>
                <a href="view_clients" class="active">Clients</a>
                <a href="logout.php">Déconnexion</a>
            </nav>
        </aside>

        <!-- Contenu principal -->
        <main class="main-content">
            <h2>Gestion des clients</h2>
            <?php if ($result && $result->num_rows > 0): ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom et prénom</th>
                        <th>Email</th>
                        <th>Adresse</th>
                        <th>Mot de passe</th>
                        <th>Actions</th>
                    </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['nom']." ".$row['prenom']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['adresse'] ?? 'Non renseignée') ?></td>
            <td><?= htmlspecialchars($row['password']) ?></td>
            <td class="action-buttons">
            
            <a class="btn-edit" href="edit_client.php?id=<?= $row['id'] ?>">Modifier</a>
    <form method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?');">
        <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
        <button type="submit" class="btn-delete">Supprimer</button>
    </form>
    
</td>

        </tr>
        <?php endwhile; ?>
    </table>
    <?php else: ?>
        <p style="text-align:center;">Aucun client trouvé.</p>
    <?php endif; ?>

</body>
</html>

<?php
$conn->close();
?>


