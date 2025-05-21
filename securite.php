<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Connexion & Sécurité - SOOKLINE</title>
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
    $stmt = $conn->prepare("SELECT email, password FROM clients WHERE id = ?");
    $stmt->bind_param("i", $id_client);
    $stmt->execute();
    $result = $stmt->get_result();
    $client = $result->fetch_assoc();

    // Mise à jour si formulaire soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!empty($_POST['email'])) {
            $newEmail = trim($_POST['email']);
            $stmt = $conn->prepare("UPDATE clients SET email = ? WHERE id = ?");
            $stmt->bind_param("si", $newEmail, $id_client);
            $stmt->execute();
            $client['email'] = $newEmail;
        }
        if (!empty($_POST['password'])) {
            $newPassword = trim($_POST['password']);
            $stmt = $conn->prepare("UPDATE clients SET password = ? WHERE id = ?");
            $stmt->bind_param("si", $newPassword, $id_client);
            $stmt->execute();
            $client['password'] = $newPassword;
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
        <h2>Connexion et Sécurité</h2>

        <form method="POST">
            <div class="security-item">
                <h3>Email</h3>
                <p id="email-value"><?= htmlspecialchars($client['email'] ?? 'Non renseigné') ?></p>
                <button type="button" onclick="toggleForm('email-form')">Modifier</button>
                <div class="edit-form" id="email-form">
                    <input type="email" name="email" placeholder="Nouvel email">
                    <button type="submit">Enregistrer</button>
                </div>
            </div>

            <div class="security-item">
                <h3>Mot de passe</h3>
                <p id="password-value"><?= htmlspecialchars($client['password'] ?? 'Non renseigné') ?></p>
                <button type="button" onclick="toggleForm('password-form')">Modifier</button>
                <div class="edit-form" id="password-form">
                    <input type="password" name="password" placeholder="Nouveau mot de passe">
                    <button type="submit">Enregistrer</button>
                </div>
            </div>
        </form>

        <script>
            function toggleForm(id) {
                const form = document.getElementById(id);
                form.style.display = (form.style.display === 'block') ? 'none' : 'block';
            }
        </script>

    </div>
</div>

<?php include 'footer.php'; ?>

</body>

</html>
