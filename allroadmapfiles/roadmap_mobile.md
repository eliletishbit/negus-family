## passage pwa et application mobile

 un pwa permet à tes utilisateurs d'installer l'app sur leur téléphone immédiatement via le navigateur, sans attendre les validations de Google Play Store.Voici le fichier de référence : roadmap_mobile.md.
 
 6. FICHIER : roadmap_mobile.mdCe document définit l'évolution de Negus Family de la version Web vers la version Mobile native.
 
 6.1 Phase 1 : Le passage en PWA (Juin 2026)
 L'objectif est de rendre l'application web "installable" sur Android et iOS comme une application native, avec une icône sur l'écran d'accueil.A. Pourquoi la PWA pour le MVP ?Pas de Store : Pas besoin de payer 25$ à Google ou 99$ à Apple.Mises à jour instantanées : Quand tu modifies ton code Laravel, l'app de l'utilisateur est mise à jour au prochain rafraîchissement.
 
 Poids plume : L'application ne pèse presque rien.B. Étapes de mise en place (Laravel)Le Manifeste (manifest.json) : Créer un fichier qui définit le nom, les icônes et la couleur de la barre d'adresse.Le Service Worker : Un fichier JavaScript qui permet la mise en cache (pour que l'app s'ouvre même sans connexion internet stable).
 
 Librairie recommandée : Utiliser laravel-pwa (par silviolleite) pour générer tout cela automatiquement.Commande : composer require silviolleite/laravel-pwaConfiguration des icônes de la maison de production "Negus Music".
 
 6.2 Phase 2 : Application Mobile Native (Horizon 2027)Si le projet décolle, tu devras passer à une version native pour de meilleures performances (lecteur audio en arrière-plan plus stable, notifications push natives).
 
 A. Stack Technologique RecommandéeMobile : Flutter (Dart).Pourquoi ? Un seul code pour Android et iOS, excellente gestion du streaming audio, et tu restes dans une logique "UI moderne" proche de ce que tu connais.Backend : Laravel API.Tu gardes ton projet actuel mais tu ajoutes des routes API (routes/api.php).Authentification : Laravel Sanctum.Indispensable pour sécuriser la connexion entre l'app Flutter et ton serveur Laravel.
 
 B. Changements Majeurs à prévoirRefonte de l'Upload : Les fichiers devront être envoyés via des requêtes API multipart.Gestion du Stockage : Utiliser un service comme Amazon S3 ou DigitalOcean Spaces pour servir les fichiers audio rapidement partout dans le monde via CDN.Paiement Mobile : Utiliser les WebViews de Flutter pour appeler tes liens de paiement FedaPay existants, ou intégrer les SDK natifs.
 
 6.3 Comparatif Technique pour ton choix futurCaractéristiquePWA (Phase 1)Native Flutter (Phase 2)Coût de dévTrès Faible (0€)Moyen (Temps + Apprentissage)InstallationNavigateur (Ajouter à l'écran)Play Store / App StoreNotificationsLimitées (Android seulement)Totale (Push Firebase)Accès Hors-ligneBasique (Cache)Avancé (Base de données locale)AudioS'arrête parfois en veilleLecture stable en arrière-plan
 
 6.4 Conseils pour la transition (Solo Dev)API First : Même si tu développes en Blade pour le moment, essaie de mettre ta logique métier dans des Services (Classes PHP) plutôt que directement dans les Contrôleurs. Cela facilitera l'écriture de l'API plus tard.Domaine : Assure-toi d'avoir un certificat SSL (HTTPS) dès le début. Sans HTTPS, une PWA ne peut pas fonctionner.