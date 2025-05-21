<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - Admin SOOKLINE</title>
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
                <a href="dashboard.php" class="active">Dashboard</a>
                <a href="produits.php">Produits</a>
                <a href="view_clients.php">Clients</a>
                <a href="logout.php">Déconnexion</a>
            </nav>
        </aside>
        <!-- Contenu principal -->
        <main class="main-content">
            <h2>Bienvenue sur le tableau de bord</h2>

            <?php
            require_once 'db.php';

            $nbProduits = $conn->query("SELECT COUNT(*) FROM produits")->fetch_row()[0];
            $nbClients = $conn->query("SELECT COUNT(*) FROM clients")->fetch_row()[0];
            ?>

            <div class="dashboard-cards">
                <div class="card">
                    <h3>Produits</h3>
                    <p><?= $nbProduits ?> produits</p>
                    <a href="produits.php" class="btn-dashboard">Gérer</a>
                </div>
                <div class="card">
                    <h3>Clients</h3>
                    <p><?= $nbClients ?> clients</p>

                    <a href="view_clients.php" class="btn-dashboard">Voir</a>
                </div>
            </div>
        </main>
    </div>
</body>

</html>