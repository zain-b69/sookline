<?php
session_start();
$message = '';
if (!empty($_SESSION['register_error'])) {
    $message = $_SESSION['register_error'];
    unset($_SESSION['register_error']);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <title>Inscription - SOOKLINE</title>
  <link rel="stylesheet" href="style.css"> 
</head>

<body>
  <!-- BAR -->
   <?php include 'bar.php'; ?>
  <!-- CONTENU -->
  <div class="container">
    <div class="left-text">
      <h1>Créez votre compte SOOKLINE</h1>
      <p>Rejoignez-nous et profitez de milliers de produits, d'offres exclusives et bien plus encore.</p>
    </div>

    <div class="card">
      <h2>Inscription</h2>
      <?php if (!empty($message)) : ?>
    <div style="color: red; margin-bottom: 10px;"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>
      <form  method="POST">
        <input type="text" name="nom" placeholder="Nom" required>
        <input type="text" name="prenom" placeholder="Prénom" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit">Créer un compte</button>
        </form>
        <div class="signup">
          Déjà un compte ? <a href="login.php">Se connecter</a>
        </div>
    </div>
  </div>

  <!-- FOOTER -->
  <?php include 'footer.php'; ?>
</body>

</html>
<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nom = $_POST['nom'];
  $prenom = $_POST['prenom'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Vérifier si l'email existe déjà
  $stmt = $conn->prepare("SELECT * FROM clients WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();    

  if ($result && $result->num_rows > 0) {
      $_SESSION['register_error'] = "Cet email est déjà utilisé.";
      header("Location: register.php");
      exit();
  }

  // Insérer l'utilisateur (mot de passe sécurisé conseillé)
  $stmt = $conn->prepare("INSERT INTO clients (nom, prenom, email, password) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $nom, $prenom, $email, $password);
  $stmt->execute();

  // Rediriger vers login
  header("Location: login.php");
  exit();
}
?>
