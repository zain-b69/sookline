<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Vos Commandes - SOOKLINE</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php 
    session_start(); 
    include 'bar.php'; 
    require_once 'db.php';
    $id_client = $_SESSION['client_id'] ?? null;
    ?>

    <!-- CONTENU PRINCIPAL -->
    <div class="main-container">
        <!-- Sidebar gauche -->
        <?php include 'menu_gauche.php'; ?>

        <!-- Contenu des commandes -->
        <div class="content">
            <h2>Vos commandes</h2>

            <?php
            if ($id_client) {
                $stmt = $conn->prepare("SELECT * FROM commandes WHERE id_client = ?");
                $stmt->bind_param("i", $id_client);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='order-item'>";
                        echo "<h3>Commande #" . htmlspecialchars($row['id']) . "</h3>";
                        echo "<p>Statut : <strong>" . htmlspecialchars($row['statut'] ?? 'En cours') . "</strong></p>";
                        echo "<p>Total : " . number_format($row['total'], 2) . " DH</p>";
                        echo "<p>Moyen de paiement : " . htmlspecialchars($row['mode_paiement'] ?? 'Non spécifié') . "</p>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>Aucune commande trouvée.</p>";
                }
            } else {
                echo "<p>Veuillez vous connecter pour voir vos commandes.</p>";
            }
            ?>

        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>
