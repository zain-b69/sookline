<div class="sidebar">

    <h2>Bonjour <span class="client-name"><?= htmlspecialchars($_SESSION['prenom'] ?? 'Client') ?></span></h2>

    <div class="card-sidebar">
        <a href="securite.php">
            <h3>Connexion et sécurité</h3>
            <p>Modifiez votre mot de passe.</p>
        </a>
    </div>

    <div class="card-sidebar">
        <a href="adresse.php">
            <h3>Adresse</h3>
            <p>Gérez vos adresses de livraison.</p>
        </a>
    </div>

    <div class="card-sidebar">
        <a href="commandes.php">
            <h3>Vos commandes</h3>
            <p>Suivez vos achats et factures.</p>
        </a>
    </div>

    <div class="card-sidebar">
        <a href="panier.php">
            <h3>Votre panier</h3>
            <p>Consultez vos articles.</p>
        </a>
    </div>

    <a href="logout.php" class="card-sidebar" style="box-shadow: none;">
        <button class="valider-btn" style=" border-style: none; " > Déconnecter </button>
    </a>
      
      
</div>