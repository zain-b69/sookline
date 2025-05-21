<?php


$host = 'localhost';      
$dbname = 'sookline';      // Remplace par le nom de ta base
$username = 'root';        // Ton user MySQL 
$password = 'hello';       // Ton mot de passe

// Connexion MySQLi orientée objet
$conn = new mysqli($host, $username, $password, $dbname);

// Gestion d'erreur de connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

?>
