# SookLine

SookLine est une application web e-commerce développée en PHP et MySQL. Elle permet aux utilisateurs de naviguer parmi une sélection de produits, d'ajouter des articles à leur panier, de finaliser une commande, et de gérer leur compte personnel.

## Fonctionnalités

### Côté client :
- Parcourir les produits par catégorie
- Rechercher un produit
- Ajouter au panier
- Modifier les quantités
- Supprimer un produit du panier
- Finaliser la commande (paiement à la livraison ou par carte)
- Gérer ses informations personnelles (email, mot de passe, téléphone, adresse)
- Historique des commandes

### Côté administrateur :
- Tableau de bord avec résumé des données
- Ajouter / modifier / supprimer un produit
- Voir la liste des clients
- Modifier les informations d’un client
- Supprimer un client

## Structure

- `bar.php`, `footer.php` : composants réutilisables
- `dashboard.php` : interface admin
- `produits.php`, `add_product.php`, `edit_product.php` : gestion des produits
- `view_clients.php`, `edit_client.php` : gestion des clients
- `register.php`, `login.php`, `profil_client.php` : authentification
- `panier.php`, `valider_commande.php` : panier et commandes

## Technologies utilisées

- PHP 
- MySQL
- HTML / CSS 
- Git & GitHub

## Installation locale

1. Cloner le projet :
   ```bash
   git clone https://github.com/zain-b69/sookline.git
   ```

2. Importer le fichier `.sql` dans phpMyAdmin 

3. Placer le projet dans le dossier `www` de WAMP ou XAMPP

4. Configurer `db.php` avec vos identifiants MySQL

5. Lancer le serveur Apache/MySQL et accéder à :
   ```
   http://localhost/PHPPROJECT
   ```

## Auteurs

Projet réalisé dans le cadre d’un mini-projet académique par Belkhou Zainab & ElBaghdadi Hajar  
Licence SMI — Faculté des Sciences, Rabat
