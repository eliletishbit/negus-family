## Ce document est crucial car il explique le "pourquoi" de chaque table et comment elles sont liées entre elles. C'est ce qui te permettra de coder tes modèles Eloquent dans Laravel sans faire d'erreurs de logique.

2. FICHIER : database_details.md
Ce document détaille l'architecture des données et les règles de gestion du système d'information de Negus Family.

2.1 Architecture Globale
Le système utilise une base de données relationnelle MySQL. L'objectif est de minimiser la redondance des données tout en permettant une flexibilité entre les différents types de contenus (musique, produits, services).

2.2 Détails des Tables & Champs
A. Entités Utilisateurs (Identité & Finance)
utilisateurs (users) :

id : Clé primaire.

role : Détermine l'interface affichée (admin, artiste, client, sponsor, publicitaire).

num_whatsapp : Stocké au format international (ex: +228...) pour les redirections directes.

solde_virtuel : (Optionnel ici ou dans une table liée) Somme des gains non encore retirés.

portefeuilles (wallets) :

Lié à un utilisateur. Stocke le solde_disponible (ce qu'il peut retirer) et le solde_total_gagne (statistiques).

B. Entités de Contenu (Le Catalogue)
titres (tracks) :

artiste_id : Clé étrangère vers utilisateurs.

prix : Si mis à 0, le système ignore l'étape de paiement.

fichier_apercu : URL vers un fichier MP3/MP4 dans le dossier public/uploads/demos.

fichier_complet : Chemin vers le fichier dans storage/app/private/musiques. Jamais accessible via URL directe.

emissions (shows) :

code_youtube : On stocke uniquement l'ID (ex: dQw4w9WgXcQ) pour reconstruire l'Iframe.

categorie : Tags pour le filtrage (Interview, Live, Docu).

C. Entités E-Commerce & Sponsoring
produits (products) :

type : Enum ('physique', 'service').

Règle de gestion : Si type = 'service', le front-end remplace le tunnel d'achat par un lien WhatsApp.

commandes (orders) :

client_id : L'acheteur.

statut : 'en_attente' (créé), 'paye' (confirmé par FedaPay), 'livre' (pour le physique).

ref_fedapay : L'ID de transaction externe pour les audits.

lignes_commande (order_items) :

Polymorphisme simplifié : Contient titre_id (nullable) et produit_id (nullable).

Cela permet d'avoir un seul panier contenant à la fois des chansons et des casquettes.

contacts_debloques :

Table d'association entre un Sponsor et un Artiste. Si une ligne existe ici, le sponsor peut voir le numéro WhatsApp de l'artiste sur son profil.

2.3 Schéma des Relations (Logic)
One-to-Many (Un vers Plusieurs) :

Un Artiste -> Plusieurs Titres.

Un Utilisateur -> Plusieurs Commandes.

Une Commande -> Plusieurs Lignes de commande.

Many-to-Many (Plusieurs vers Plusieurs) :

Un Sponsor -> Plusieurs Artistes (via contacts_debloques).

Un Utilisateur -> Plusieurs Publications (via interactions pour les likes).

2.4 Flux de Données Critique : L'Achat d'un Son
Le Client crée une Commande.

FedaPay confirme le succès du paiement.

Le Statut de la commande passe à 'paye'.

Le système identifie l'Artiste via la Ligne_commande.

Le Portefeuille de l'artiste est crédité de (Prix - Commission %).

Une autorisation est créée pour que le Client puisse télécharger le fichier_complet.