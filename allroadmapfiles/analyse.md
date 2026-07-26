## Ce document définit le périmètre fonctionnel du projet Negus Family pour l'échéance du 15 juin 2026.

## 1.1 Objectifs du Projet
Développer une plateforme "tout-en-un" pour la maison de production Negus Music, permettant de centraliser la gestion des artistes, la vente de musique, le merchandising physique et la mise en relation professionnelle (sponsoring).

## 1.2 Spécifications des Rôles (ACL)
Le système repose sur une gestion fine des droits d'accès :

Visiteur (Non connecté) :

Consultation du catalogue musical (extraits de 30s).

Lecture des émissions (YouTube Embed).

Consultation des événements et de la boutique.

Client/Fan (Connecté) :

Achat de titres musicaux (accès au fichier complet après paiement).

Gestion du panier (produits physiques).

Interaction sociale (Likes/Commentaires) sur les posts des artistes.

Espace "Ma Musique" pour retrouver ses achats numériques.

Artiste :

Tableau de bord (Dashboard) affichant les ventes et le solde du portefeuille.

Upload de contenus (Audio/Vidéo) avec gestion du prix.

Création de "Posts" (texte/image) pour sa communauté.

Gestion des demandes de collaboration avec d'autres artistes.

Sponsor & Publicitaire :

Consultation des fiches artistes détaillées.

Paiement de "frais de mise en relation" (Lead Generation) pour débloquer le contact direct (WhatsApp/Email) d'un artiste.

Publication d'offres de sponsoring.

Administrateur (Negus Music) :

Modération globale (utilisateurs, commentaires, contenus).

Gestion du catalogue des émissions et de l'agenda des événements.

Validation des demandes de retrait d'argent des artistes.

## 1.3 Modules Fonctionnels détaillés
A. Le Module Streaming & Protection
Le système doit gérer deux types de fichiers pour chaque titre :

L'aperçu (Demo) : Fichier léger, stocké de façon publique, accessible à tous.

Le Master (Final) : Fichier haute qualité, stocké dans un répertoire sécurisé de Laravel (storage/app/private), non accessible via une URL directe. L'accès est généré par un contrôleur après vérification de l'achat.

B. Le Module E-Commerce (Hybride)
Produits Physiques : Gestion classique du stock. Si stock = 0, bouton "Épuisé".

Services : Pour les formations ou la production, le bouton "Acheter" est remplacé par un lien direct "Contact WhatsApp Business" avec un message pré-rempli.

Panier : Utilisation d'une session pour stocker les produits avant le passage à la caisse (Checkout).

C. Le Module Sponsoring (Lead Generation)
Pour éviter la complexité juridique des contrats, la plateforme agit comme un annuaire premium. Le sponsor paie un montant fixe (ex: 5 000 FCFA) pour voir les coordonnées de l'artiste. Une fois payé, le lien reste débloqué à vie pour ce sponsor sur cet artiste.

D. Le Module Portefeuille (Escrow Virtuel)
Chaque vente crédite le compte "virtuel" de l'artiste (Montant vente - Commission maison).

L'argent réel est encaissé sur le compte FedaPay de Negus Music.

L'artiste peut demander un retrait dès qu'il atteint un seuil défini (ex: 10 000 FCFA).

1.4 Indicateurs de réussite pour le MVP (15 Juin)
Processus d'inscription et de choix de rôle fonctionnel.

Upload et lecture audio/vidéo opérationnels.

Tunnel d'achat complet (Panier -> FedaPay -> Confirmation).

Dashboard Admin permettant de voir les transactions.