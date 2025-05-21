<!-- TOP BAR -->
  <div class="top-bar" id="top-bar">
    <div class="top-left">
      <div class="logo"></div>
      <a href="acc2.php">
        <img src="logo.png" alt="Logo" class="logo-img">
      </a>
      <div class="location">
        <span>Votre adresse de livraison :</span>
        <strong>Maroc</strong>
      </div>
    </div>

    <div class="search-container">
      <form method="POST" action="recherche.php">
        <select name="categorie">
          <option value="">Toutes nos catégories</option>
          <option value="Vêtements">Vêtements</option>
          <option value="Electronique">Electronique</option>
          <option value="Accessoires">Accessoires</option>
          <option value="Maison">Maison</option>
          <option value="Livres">Livres</option>
        </select>
        <input type="text" name="motcle" placeholder="Rechercher...">
        <button type="submit" name="rechercher">Rechercher🔍</button>
      </form>

    </div>

    <div class="nav-right">
      <div class="lang-select">
        <img src="https://flagcdn.com/fr.svg" alt="FR">
        <span>FR</span>
      </div>
      <div class="nav-links">
        <?php
          if (session_status() === PHP_SESSION_NONE) {
            session_start();
          }
          if (isset($_SESSION['client_id'])) {
              echo '<a href="profil_client.php">Compte</a>';
          }
          else if (isset($_SESSION['admin_id'])) {
              echo '<a href="admin.php">Compte</a>';
          }
          else {
              echo '<a href="login.php">Compte</a>';
          }
        ?> |
        <a href="historique_commandes">Commandes</a> |
        <a href="panier.php">Panier</a>
      </div>
    </div>
  </div>