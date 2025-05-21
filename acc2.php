<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Accueil - Ma Boutique</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'bar.php'; ?>

  <!-- HERO SECTION -->
  <div class="hero-section" id="hero-section">
    <div class="category-container">
     <div class="category-card">
  <h3>Accessoires Electroniques</h3>
  <img src="img/GMA.jpg" >
  <form method="POST" action="recherche.php">
     <input type="hidden" name="categorie" value="Electronique"> 
	  <input type="hidden" name="motcle" value="">
    <button type="submit" name="rechercher">Voir plus</button>
  </form>
</div>

<div class="category-card">
  <h3>Top catégories d'Accessoires</h3>
  <img src="img/KITCHEN.jpg" >
  <form method="POST" action="recherche.php">
    <input type="hidden" name="categorie" value="Accessoires">
	 <input type="hidden" name="motcle" value="">
    <button type="submit" name="rechercher">Voir plus</button>
  </form>
</div>

<div class="category-card">
  <h3>Achetez les essentiels de votre maison</h3>
  <img src="img/PILLOW.jpg" alt="Home">
  <form method="POST" action="recherche.php">
    <input type="hidden" name="categorie" value="Maison">
	 <input type="hidden" name="motcle" value="">
    <button type="submit" name="rechercher">Voir plus</button>
  </form>
</div>

<div class="category-card">
  <h3>Offres de Fashion</h3>
  <img src="img/CLOTHE.jpg" alt="Fashion">
  <form method="POST" action="recherche.php">
    <input type="hidden" name="categorie" value="Vêtements"> 
	 <input type="hidden" name="motcle" value="">
    <button type="submit" name="rechercher">Voir plus</button>
  </form>
</div>

    </div>
  </div>
      <!-- FOOTER -->
     <?php include 'footer.php'; ?>
    

</body>
</html>
