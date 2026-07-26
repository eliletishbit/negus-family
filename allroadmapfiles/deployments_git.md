## Voici le dernier fichier, deployment_git.md, mis à jour avec la section Installation & Dépendances. Ce document te servira de guide "pas à pas" pour monter l'environnement technique.

5. FICHIER : deployment_git.md
Ce document contient la procédure d'initialisation, la gestion des dépendances et la méthodologie de travail sur Git.

5.1 Initialisation du Projet & Dépendances
Exécute ces commandes dans l'ordre pour configurer ton environnement de développement.

A. Création du projet et Authentification
B. Installation des librairies spécifiques au projet
5.2 Méthodologie Git (Travail Solo & Équipe)
A. Configuration initiale
B. Routine de travail (Workflow)
Ne travaille jamais directement sur la branche main. Utilise une branche par fonctionnalité.

Créer une branche : git checkout -b feature/nom-de-la-feature

Coder & Commiter : git commit -am "Ajout de l'upload audio"

Fusionner : - Revenir sur main : git checkout main

Fusionner : git merge feature/nom-de-la-feature

Nettoyer : git branch -d feature/nom-de-la-feature

C. Collaboration & Déploiement
Fichier .env : Ne jamais pousser ton fichier .env sur GitHub. Assure-toi que le fichier .env.example contient toutes les clés nécessaires (FEDAPAY_SECRET, etc.).

Migrations : Avant de partager ton code ou de déployer, vérifie que tes migrations sont à jour : php artisan migrate:status.

Production : Lors du passage en ligne, n'oublie pas de lier le stockage pour que les fichiers publics soient accessibles : php artisan storage:link.

5.3 Résumé de l'ordre d'exécution pour toi
Migrations : Créer tes fichiers de migration dans database/migrations en copiant la logique de notre fichier database.sql.

Modèles : Créer tes modèles Eloquent (User, Titre, Commande, etc.).

Logique Métier : Commencer par l'inscription des utilisateurs (Breeze le fait déjà à 90%).

Paiement : Intégrer le SDK FedaPay en dernier, une fois que le tunnel d'achat (panier) fonctionne en local.