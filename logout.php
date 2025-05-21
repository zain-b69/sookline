<?php
session_start();
session_unset(); // Supprime toutes les variables de session
session_destroy(); // Détruit la session

// Rediriger vers la page de connexion ou d'accueil
header("Location: login.php");
exit();
?>
