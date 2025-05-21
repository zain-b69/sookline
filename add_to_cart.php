<?php


session_start();

// Connexion simple 
$conn = mysqli_connect("localhost", "root", "hello", "sookline");
if (!$conn) {
    die("Connexion échouée: " . mysqli_connect_error());
}

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

// Récupérer l'id du produit et l'utilisateur
$id_produit = $_POST['id'];
$id_client = $_SESSION['client_id'] ?? null;
if (!$id_client) {
    echo"<script>alert('Veuillez vous connecter pour ajouter un produit au panier.');</script>";
    exit();
}

// Récupérer les données du produit depuis la base
$query = "SELECT * FROM produits WHERE id = '$id_produit'";
$result = mysqli_query($conn, $query);
$produit = mysqli_fetch_assoc($result);

if (!$produit) {
    die("Produit non trouvé");
}

// Ajouter au panier PHP (session)
if (!isset($_SESSION['panier'][$id_produit])) {
    $_SESSION['panier'][$id_produit] = [
        'nom' => $produit['nom'],
        'prix' => $produit['prix'],
        'quantite' => 1,
        'img' => $produit['img'],
        'description' => $produit['description'],
        'categorie' => $produit['categorie']
    ];
} else {
    $_SESSION['panier'][$id_produit]['quantite']++;
}

$quantite = $_SESSION['panier'][$id_produit]['quantite'];

// Vérifier si le produit existe déjà dans la table panier
$check_sql = "SELECT * FROM panier WHERE id_client = '$id_client' AND id_produit = '$id_produit'";
$check_result = mysqli_query($conn, $check_sql);

if (mysqli_num_rows($check_result) > 0) {
    // Mise à jour de la quantité
    $update_sql = "UPDATE panier SET quantite = '$quantite' WHERE id_client = '$id_client' AND id_produit = '$id_produit'";
    mysqli_query($conn, $update_sql);
} else {
    // Insertion d'une nouvelle ligne
    $insert_sql = "INSERT INTO panier (id_client, id_produit, quantite) VALUES ('$id_client', '$id_produit', '$quantite')";
    mysqli_query($conn, $insert_sql);
}

mysqli_close($conn);
header("Location: panier.php");
exit();
?>
