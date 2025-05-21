<!DOCTYPE html>
<html lang="fr">
<?php
// On stocke puis supprime le message dès qu'il est affiché
$message = '';
if (!empty($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}
?>

<head>
  <meta charset="UTF-8" />
  <title>Connexion - SOOKLINE</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <?php include 'bar.php'; ?>

  <div class="container">
    <div class="left-text">
      <h1>Connectez-vous pour continuer</h1>
      <p>Accédez à votre compte, suivez vos commandes et profitez d'une expérience fluide.</p>
    </div>
    <div class="card">
      <h2>Connexion</h2>
      <?php if (!empty($message)) : ?>
    <div style="color: red; margin-bottom: 10px;"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>


      <form method="POST" action="adminlogin.php">
        <input type="text" name="username" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit" name="login">Connexion</button>
        <div class="signup">
          Pas de compte ? <a href="register.php">Créer un compte</a>
        </div>
      </form>
    </div>
  </div>

  <?php include 'footer.php'; ?>
</body>

</html>