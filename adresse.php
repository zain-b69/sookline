<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Votre Adresse - SOOKLINE</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php 
    include 'bar.php'; 
    require_once 'db.php';
    $id_client = $_SESSION['client_id'] ?? null;
    $adresse = '';
    $success = false;

    if ($id_client) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adresse'])) {
            $nouvelle_adresse = trim($_POST['adresse']);
            $stmt = $conn->prepare("UPDATE clients SET adresse = ? WHERE id = ?");
            $stmt->bind_param("si", $nouvelle_adresse, $id_client);
            $success = $stmt->execute();            
            $adresse = $nouvelle_adresse;
        } else {
            $stmt = $conn->prepare("SELECT adresse FROM clients WHERE id = ? LIMIT 1");
            $stmt->bind_param("i", $id_client);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $adresse = $row['adresse'];
            }
        }
    }
    ?>

    <!-- CONTENU -->
    <div class="main-container">
        <!-- Colonne gauche -->
        <?php include 'menu_gauche.php'; ?>

        <!-- Contenu droite -->
        <div class="content">
            <h2>Votre adresse</h2>

            <?php if ($success): ?>
                <div class="success-alert"><span class="icon">✅</span> Adresse mise à jour avec succès !</div>
            <?php endif; ?>

            <div class="address-item">
                <p id="address-text">
                    <?= htmlspecialchars($adresse ?: 'Aucune adresse enregistrée') ?>
                </p>
                <button onclick="toggleForm('edit-form')">Modifier</button>

                <div class="edit-form" id="edit-form">
                    <form method="post">
                        <input type="text" name="adresse" placeholder="Nouvelle adresse" required>
                        <button type="submit">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        function toggleForm(id) {
            const form = document.getElementById(id);
            form.style.display = (form.style.display === 'block') ? 'none' : 'block';
        }
    </script>

</body>

</html>
