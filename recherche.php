<?php
session_start();
$host = 'localhost';
$dbname = 'sookline';
$username = 'root';
$password = 'hello';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}
$query = "SELECT * FROM produits";

if (isset($_POST['rechercher'])) {
    $categorie = $_POST['categorie'];
    $motcle = $_POST['motcle'];

    // Construct the query based on conditions
    if (!empty($categorie) && !empty($motcle)) {
        // Both category and keyword are provided
        $query = "SELECT * FROM produits WHERE categorie = '$categorie' AND (nom LIKE '%$motcle%' OR description LIKE '%$motcle%')";
    } elseif (!empty($categorie)) {
        // Only category is provided
        $query = "SELECT * FROM produits WHERE categorie = '$categorie'";
    } elseif (!empty($motcle)) {
        // Only keyword is provided
        $query = "SELECT * FROM produits WHERE nom LIKE '%$motcle%' OR description LIKE '%$motcle%'";
    }
	
}
$res = $conn->query($query);
$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Catégorie - Ma Boutique</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'bar.php'; ?>

  <!-- MAIN CONTENT -->
  <div class="main-content">

    <!-- FILTRES -->
    <div class="filters">
      <h3>Catégorie</h3>
      <label><input type="checkbox" class="filter-category" value="Vêtements"> Vêtements</label>
      <label><input type="checkbox" class="filter-category" value="Electronique"> Electronique</label>
      <label><input type="checkbox" class="filter-category" value="Accessoires"> Accessoires</label>
      <label><input type="checkbox" class="filter-category" value="Maison"> Maison</label>
      <label><input type="checkbox" class="filter-category" value="Livres"> Livres</label>

      <h3>Trier par</h3>
      <select id="sort-Price">
        <option value="">-- Choisir --</option>
        <option value="asc">Prix croissant</option>
        <option value="desc">Prix décroissant</option>
      </select>
      
    </div>

    <!-- PRODUITS -->
    <div class="products">
      <div class="results-info">
        Résultats<br>
      </div>

      <div class="product-grid">
        <?php
          if ($res->num_rows > 0) {
              while ($row = $res->fetch_assoc()) {
                echo "
                <div class='product-card' data-category='{$row['categorie']}' data-price='{$row['prix']}' data-rating='{$row['avis']}'>
                    <img src='img/{$row['img']}' alt='{$row['nom']}'>
                    <h4>{$row['nom']}</h4>
                    <p>{$row['description']}</p>
                    <span>{$row['prix']} dh</span>
                
                    <form method='POST' action='add_to_cart.php'>
                        <input type='hidden' name='id' value='{$row['id']}'>
                        <input type='hidden' name='nom' value='{$row['nom']}'>
                        <input type='hidden' name='prix' value='{$row['prix']}'>
                        <button type='submit' class='addtocart'>Ajouter au Panier</button>
                    </form>
                </div>";
                
              }
          } else {
              echo "<p>Aucun produit trouvé.</p>";
          }
        ?>
      </div> <!-- close .product-grid -->
    </div> <!-- close .products -->

  
  </div>      
        
  <!-- SCROLL TO TOP BUTTON -->
    <div style="text-align: center; padding: 20px; background-color: #37475a;">
        <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" 
                style="padding: 10px 20px; background-color: #232f3e; color: white; border: none; cursor: pointer; border-radius: 4px;">
          Retour en haut
        </button>
      </div>

  <?php include 'footer.php'; ?>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const productsContainer = document.querySelector('.product-grid');
      const products = Array.from(productsContainer.children);
      const sortSelect = document.getElementById('sort-Price');
      const categoryCheckboxes = document.querySelectorAll('.filter-category');
  
      const ratingRadios = document.querySelectorAll('input[name="filter-rating"]');

function applyFilters() {
  const selectedCategories = Array.from(categoryCheckboxes)
    .filter(cb => cb.checked)
    .map(cb => cb.value);

  const selectedRating = parseFloat(document.querySelector('input[name="filter-rating"]:checked')?.value) || 0;

  return products.filter(product => {
    const category = product.dataset.category;
    const rating = parseFloat(product.dataset.rating) || 0;

    const categoryMatch = selectedCategories.length === 0 || selectedCategories.includes(category);
    const ratingMatch = rating >= selectedRating;

    return categoryMatch && ratingMatch;
  });
}

ratingRadios.forEach(rb => rb.addEventListener('change', updateDisplay));

  
      function sortProducts(productsArray, order) {
        return productsArray.sort((a, b) => {
          const priceA = parseFloat(a.dataset.price);
          const priceB = parseFloat(b.dataset.price);
          return order === 'asc' ? priceA - priceB : priceB - priceA;
        });
      }
  
      function updateDisplay() {
        const selectedSort = sortSelect.value;
        const filtered = applyFilters();
        const sorted = selectedSort ? sortProducts(filtered, selectedSort) : filtered;
  
        productsContainer.innerHTML = '';
        sorted.forEach(product => productsContainer.appendChild(product));
      }
  
      sortSelect.addEventListener('change', updateDisplay);
      categoryCheckboxes.forEach(cb => cb.addEventListener('change', updateDisplay));
    });
	
	document.addEventListener('DOMContentLoaded', function() {
    const addToCartButtons = document.querySelectorAll('.add-to-cart');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            addToCart(productId);
        });
    });

    function addToCart(productId) {
        // You can send the productId to the server to update the cart in the session
        console.log('Product added to cart: ' + productId);
        // Example of how you could send the product ID using AJAX (you can replace this with actual AJAX code)
        fetch('add_to_cart.php', {
            method: 'POST',
            body: JSON.stringify({ productId: productId }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            alert('Produit ajouté au panier');
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
});

  </script>
</body>
</html>