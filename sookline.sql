-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 21, 2025 at 10:03 PM
-- Server version: 8.0.39
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sookline`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `email`) VALUES
(1, 'admin1', 'pwd1', 'admin1@example.com'),
(2, 'admin2', 'pwd2', 'admin2@example.com'),
(3, 'admin3', 'pwd3', 'admin3@example.com');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `prenom` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `adresse` text COLLATE utf8mb4_general_ci,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `nom`, `prenom`, `email`, `adresse`, `password`) VALUES
(5, 'Kobayashi', 'Hiroshi', 'hiroshi.k@japan.jp', '5-3-2 Shibuya, Tokyo', 'password5'),
(6, 'Chen', 'Li', 'li.chen@china.cn', '88 Nanjing Road, Shanghai', 'password6'),
(7, 'Smith', 'Emily', 'emily.smith@usa.com', '910 Elm Street, Chicago', 'password7'),
(8, 'Lopez', 'Carlos', 'carlos.lopez@mexico.mx', '23 Calle Reforma, Mexico City', 'password8'),
(9, 'Almeida', 'Rafaela', 'rafaela.almeida@brasil.br', '17 Rua das Flores, São Paulo', 'password9'),
(10, 'Nguyen', 'Thuy', 'thuy.nguyen@vietnam.vn', '64 Nguyen Trai, Hanoi', 'password10'),
(13, 'dubois', 'julien', 'julien.dubois@france.fr', NULL, 'julien123');

-- --------------------------------------------------------

--
-- Table structure for table `commandes`
--

DROP TABLE IF EXISTS `commandes`;
CREATE TABLE IF NOT EXISTS `commandes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_client` int NOT NULL,
  `statut` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'En attente',
  `total` decimal(10,2) NOT NULL,
  `mode_paiement` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_client` (`id_client`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `commandes`
--

INSERT INTO `commandes` (`id`, `id_client`, `statut`, `total`, `mode_paiement`) VALUES
(9, 13, 'En attente', 150.00, 'carte');

-- --------------------------------------------------------

--
-- Table structure for table `commande_produits`
--

DROP TABLE IF EXISTS `commande_produits`;
CREATE TABLE IF NOT EXISTS `commande_produits` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_commande` int NOT NULL,
  `id_produit` int NOT NULL,
  `quantite` int NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_commande` (`id_commande`),
  KEY `id_produit` (`id_produit`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `commande_produits`
--

INSERT INTO `commande_produits` (`id`, `id_commande`, `id_produit`, `quantite`, `prix`) VALUES
(1, 9, 2, 1, 150.00);

-- --------------------------------------------------------

--
-- Table structure for table `panier`
--

DROP TABLE IF EXISTS `panier`;
CREATE TABLE IF NOT EXISTS `panier` (
  `id_panier` int NOT NULL AUTO_INCREMENT,
  `id_client` int NOT NULL,
  `id_produit` int NOT NULL,
  `quantite` int DEFAULT '1',
  PRIMARY KEY (`id_panier`),
  KEY `id_client` (`id_client`),
  KEY `id_produit` (`id_produit`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `categorie` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `img` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prix` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produits`
--

INSERT INTO `produits` (`id`, `nom`, `description`, `categorie`, `img`, `prix`) VALUES
(2, 'light blue blouse', 'light blue blouse', 'Vêtements', 'RALPH LAUREN.jpg', 150.00),
(3, 'brown cuire jacket', 'brown cuire jacket', 'Vêtements', 'cuivrebrown.jpg', 120.00),
(4, 'blue grey jacket', 'blue grey jacket for kids', 'Vêtements', 'jacket.jpg', 40.00),
(5, 'socks', 'white socks', 'Vêtements', 'soks.jpg', 20.00),
(6, 'beige shorts', 'beige shorts for kids', 'Vêtements ', 'beigeshorts.jpg', 70.00),
(7, 'keybord', 'black keybord', 'Electronique ', 'White Keyboard.jpg', 80.00),
(8, 'card', 'storage card', 'Electronique', 'CARD.jpg', 230.00),
(9, 'mouse', 'white mouse', 'Electronique', 'MOUSE.jpg', 60.00),
(10, 'mind over xhatter', 'mind over chatter', 'Livres', 'MIND.jpg', 25.00),
(11, 'true wealtch', 'true wealtch', 'Livres', 'WEALTH.jpg', 25.00),
(12, 'power', 'power', 'Livres', 'images (2).jpg', 45.00),
(13, 'towel', 'light pink towel', 'Maison', 'TOWEL.jpg', 60.00),
(14, 'teapot', 'white teapot', 'Maison', 'TEAPOT.jpg', 50.00),
(15, 'clock', 'white clock', 'Maison', 'CLOCK.jpg', 75.00),
(16, 'ring', 'immerged ring', 'Accessoires', 'cartier.jpg', 200.00),
(17, 'bracelet', 'gold navy bracelet', 'Accessoires', 'bracelet.jpg', 350.00),
(18, 'papillon', 'papillon blanche', 'Accessoires', 'bow.jpg', 55.00),
(19, 'dress', 'milky dress', 'Vêtements', 'DRESS.jpg', 250.00),
(20, 'polo blue', 'T-shirt Homme', 'Vêtements', 'poloblue.jpg', 100.00);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `commande_produits`
--
ALTER TABLE `commande_produits`
  ADD CONSTRAINT `commande_produits_ibfk_1` FOREIGN KEY (`id_commande`) REFERENCES `commandes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `commande_produits_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `produits` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `panier_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `panier_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `produits` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
