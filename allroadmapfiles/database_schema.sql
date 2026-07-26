-- ======================================================
-- NEGUS MUSIC - SCHEMA BASE DE DONNÉES CORRIGÉ V3
-- Version : MVP (15 Juin 2026)
-- Moteur : MySQL 8.0+ / MariaDB 10.6+
-- ======================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
SET FOREIGN_KEY_CHECKS = 0;

-- ------------------------------------------------------
-- 1. TABLE UTILISATEURS (ROLES UNIQUES)
-- ------------------------------------------------------
DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE `utilisateurs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nom` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `mot_de_passe` VARCHAR(255) NOT NULL,
    `role` ENUM('admin', 'artiste', 'client', 'sponsor', 'publicitaire') DEFAULT 'client',
    `photo_profil` VARCHAR(255) DEFAULT NULL,
    `bio` TEXT DEFAULT NULL,
    `num_whatsapp` VARCHAR(20) DEFAULT NULL,
    `remember_token` VARCHAR(100) DEFAULT NULL,
    `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `utilisateurs_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------
-- 2. TABLE PORTEFEUILLES (WALLET ARTISTE)
-- ------------------------------------------------------
DROP TABLE IF EXISTS `portefeuilles`;
CREATE TABLE `portefeuilles` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `utilisateur_id` BIGINT UNSIGNED NOT NULL,
    `solde_disponible` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    `solde_total_gagne` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `portefeuilles_utilisateur_id_foreign` (`utilisateur_id`),
    CONSTRAINT `portefeuilles_utilisateur_id_foreign` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------
-- 3. TABLE TITRES MUSICAUX (avec commission individuelle)
-- ------------------------------------------------------
DROP TABLE IF EXISTS `titres`;
CREATE TABLE `titres` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `artiste_id` BIGINT UNSIGNED NOT NULL,
    `titre` VARCHAR(255) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `prix` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `commission` DECIMAL(5,2) NOT NULL DEFAULT 15.00 COMMENT 'Commission Negus en %',
    `fichier_apercu` VARCHAR(255) NOT NULL COMMENT 'Chemin public vers demo',
    `fichier_complet` VARCHAR(255) NOT NULL COMMENT 'Chemin privé storage/app/private',
    `type` ENUM('audio', 'video') NOT NULL DEFAULT 'audio',
    `nb_ventes` INT NOT NULL DEFAULT 0,
    `status` ENUM('brouillon', 'publie', 'archive') NOT NULL DEFAULT 'brouillon',
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `titres_artiste_id_foreign` (`artiste_id`),
    CONSTRAINT `titres_artiste_id_foreign` FOREIGN KEY (`artiste_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------
-- 4. TABLE PRODUITS PHYSIQUES & SERVICES
-- ------------------------------------------------------
DROP TABLE IF EXISTS `produits`;
CREATE TABLE `produits` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nom` VARCHAR(255) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `prix` DECIMAL(10,2) NOT NULL,
    `stock` INT NOT NULL DEFAULT 0,
    `type` ENUM('physique', 'service') NOT NULL DEFAULT 'physique',
    `image_url` VARCHAR(255) DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------
-- 5. TABLE COMMANDES (PANIER VALIDÉ)
-- ------------------------------------------------------
DROP TABLE IF EXISTS `commandes`;
CREATE TABLE `commandes` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `client_id` BIGINT UNSIGNED NOT NULL,
    `total` DECIMAL(12,2) NOT NULL,
    `commission_totale` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `mode_livraison` ENUM('digital', 'physique', 'mixte') NOT NULL DEFAULT 'digital',
    `statut` ENUM('en_attente', 'paye', 'echoue', 'livre') NOT NULL DEFAULT 'en_attente',
    `ref_fedapay` VARCHAR(255) DEFAULT NULL,
    `methode_paiement` VARCHAR(50) DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `commandes_client_id_foreign` (`client_id`),
    CONSTRAINT `commandes_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------
-- 6. TABLE LIGNES DE COMMANDE
-- ------------------------------------------------------
DROP TABLE IF EXISTS `lignes_commande`;
CREATE TABLE `lignes_commande` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `commande_id` BIGINT UNSIGNED NOT NULL,
    `titre_id` BIGINT UNSIGNED DEFAULT NULL,
    `produit_id` BIGINT UNSIGNED DEFAULT NULL,
    `prix_unitaire` DECIMAL(10,2) NOT NULL,
    `quantite` INT NOT NULL DEFAULT 1,
    `commission_ligne` DECIMAL(5,2) DEFAULT 15.00 COMMENT 'Commission appliquée sur cette ligne',
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `lignes_commande_commande_id_foreign` (`commande_id`),
    KEY `lignes_commande_titre_id_foreign` (`titre_id`),
    KEY `lignes_commande_produit_id_foreign` (`produit_id`),
    CONSTRAINT `lignes_commande_commande_id_foreign` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`) ON DELETE CASCADE,
    CONSTRAINT `lignes_commande_titre_id_foreign` FOREIGN KEY (`titre_id`) REFERENCES `titres` (`id`) ON DELETE SET NULL,
    CONSTRAINT `lignes_commande_produit_id_foreign` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------
-- 7. TABLE ACCÈS TITRES (Achats numériques)
-- ------------------------------------------------------
DROP TABLE IF EXISTS `acces_titres`;
CREATE TABLE `acces_titres` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `utilisateur_id` BIGINT UNSIGNED NOT NULL,
    `titre_id` BIGINT UNSIGNED NOT NULL,
    `token_acces` VARCHAR(255) NOT NULL,
    `expire_le` TIMESTAMP NULL DEFAULT NULL COMMENT 'NULL = accès à vie',
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `acces_titres_unique` (`utilisateur_id`, `titre_id`),
    KEY `acces_titres_titre_id_foreign` (`titre_id`),
    CONSTRAINT `acces_titres_titre_id_foreign` FOREIGN KEY (`titre_id`) REFERENCES `titres` (`id`) ON DELETE CASCADE,
    CONSTRAINT `acces_titres_utilisateur_id_foreign` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------
-- 8. TABLE CONTACTS DÉBLOQUÉS (Sponsoring)
-- ------------------------------------------------------
DROP TABLE IF EXISTS `contacts_debloques`;
CREATE TABLE `contacts_debloques` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `sponsor_id` BIGINT UNSIGNED NOT NULL,
    `artiste_id` BIGINT UNSIGNED NOT NULL,
    `commande_id` BIGINT UNSIGNED NOT NULL,
    `montant_paye` DECIMAL(10,2) NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `contacts_debloques_unique` (`sponsor_id`, `artiste_id`),
    KEY `contacts_debloques_artiste_id_foreign` (`artiste_id`),
    KEY `contacts_debloques_commande_id_foreign` (`commande_id`),
    CONSTRAINT `contacts_debloques_artiste_id_foreign` FOREIGN KEY (`artiste_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE,
    CONSTRAINT `contacts_debloques_commande_id_foreign` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`) ON DELETE CASCADE,
    CONSTRAINT `contacts_debloques_sponsor_id_foreign` FOREIGN KEY (`sponsor_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------
-- 9. TABLE DEMANDES DE RETRAIT (Artistes)
-- ------------------------------------------------------
DROP TABLE IF EXISTS `demandes_retrait`;
CREATE TABLE `demandes_retrait` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `artiste_id` BIGINT UNSIGNED NOT NULL,
    `montant` DECIMAL(12,2) NOT NULL,
    `statut` ENUM('en_attente', 'validee', 'rejetee', 'payee') NOT NULL DEFAULT 'en_attente',
    `reference_transfert` VARCHAR(255) DEFAULT NULL,
    `validee_par` BIGINT UNSIGNED DEFAULT NULL,
    `motif_rejet` TEXT DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `demandes_retrait_artiste_id_foreign` (`artiste_id`),
    KEY `demandes_retrait_validee_par_foreign` (`validee_par`),
    CONSTRAINT `demandes_retrait_artiste_id_foreign` FOREIGN KEY (`artiste_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE,
    CONSTRAINT `demandes_retrait_validee_par_foreign` FOREIGN KEY (`validee_par`) REFERENCES `utilisateurs` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------
-- 10. TABLE ÉMISSIONS (YouTube)
-- ------------------------------------------------------
DROP TABLE IF EXISTS `emissions`;
CREATE TABLE `emissions` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `titre` VARCHAR(255) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `code_youtube` VARCHAR(50) NOT NULL,
    `categorie` VARCHAR(100) DEFAULT NULL,
    `est_en_vogue` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------
-- 11. TABLE ÉVÉNEMENTS
-- ------------------------------------------------------
DROP TABLE IF EXISTS `evenements`;
CREATE TABLE `evenements` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nom` VARCHAR(255) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `date_evenement` DATETIME NOT NULL,
    `lieu` VARCHAR(255) NOT NULL,
    `prix_entree` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `affiche_url` VARCHAR(255) DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------
-- 12. TABLE PUBLICATIONS (Social Artiste)
-- ------------------------------------------------------
DROP TABLE IF EXISTS `publications`;
CREATE TABLE `publications` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `artiste_id` BIGINT UNSIGNED NOT NULL,
    `contenu` TEXT NOT NULL,
    `media_url` VARCHAR(255) DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `publications_artiste_id_foreign` (`artiste_id`),
    CONSTRAINT `publications_artiste_id_foreign` FOREIGN KEY (`artiste_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------
-- 13. TABLE LIKES
-- ------------------------------------------------------
DROP TABLE IF EXISTS `likes`;
CREATE TABLE `likes` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `utilisateur_id` BIGINT UNSIGNED NOT NULL,
    `publication_id` BIGINT UNSIGNED NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `likes_unique` (`utilisateur_id`, `publication_id`),
    KEY `likes_publication_id_foreign` (`publication_id`),
    CONSTRAINT `likes_publication_id_foreign` FOREIGN KEY (`publication_id`) REFERENCES `publications` (`id`) ON DELETE CASCADE,
    CONSTRAINT `likes_utilisateur_id_foreign` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------
-- 14. TABLE COMMENTAIRES
-- ------------------------------------------------------
DROP TABLE IF EXISTS `commentaires`;
CREATE TABLE `commentaires` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `utilisateur_id` BIGINT UNSIGNED NOT NULL,
    `publication_id` BIGINT UNSIGNED NOT NULL,
    `contenu` TEXT NOT NULL,
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `commentaires_utilisateur_id_foreign` (`utilisateur_id`),
    KEY `commentaires_publication_id_foreign` (`publication_id`),
    CONSTRAINT `commentaires_publication_id_foreign` FOREIGN KEY (`publication_id`) REFERENCES `publications` (`id`) ON DELETE CASCADE,
    CONSTRAINT `commentaires_utilisateur_id_foreign` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------
-- 15. TABLE SESSIONS (Optionnel, gestion panier)
-- ------------------------------------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
    `id` VARCHAR(255) NOT NULL,
    `user_id` BIGINT UNSIGNED DEFAULT NULL,
    `ip_address` VARCHAR(45) DEFAULT NULL,
    `user_agent` TEXT DEFAULT NULL,
    `payload` LONGTEXT NOT NULL,
    `last_activity` INT NOT NULL,
    PRIMARY KEY (`id`),
    KEY `sessions_user_id_index` (`user_id`),
    KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------
-- 16. TABLE JOBS (Pour paiements asynchrones)
-- ------------------------------------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `queue` VARCHAR(255) NOT NULL,
    `payload` LONGTEXT NOT NULL,
    `attempts` TINYINT UNSIGNED NOT NULL,
    `reserved_at` INT UNSIGNED DEFAULT NULL,
    `available_at` INT UNSIGNED NOT NULL,
    `created_at` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ======================================================
-- DONNÉES INITIALES (Optionnelles)
-- ======================================================

-- Création d'un utilisateur admin par défaut (mot de passe : password)
-- ATTENTION : À exécuter uniquement en développement
-- INSERT INTO `utilisateurs` (`nom`, `email`, `mot_de_passe`, `role`, `email_verified_at`) 
-- VALUES ('Admin Negus', 'admin@negus.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NOW());

-- Trigger : Création automatique du portefeuille quand un artiste est créé
-- À implémenter dans Laravel via l'Observer, pas en SQL direct

SET FOREIGN_KEY_CHECKS = 1;