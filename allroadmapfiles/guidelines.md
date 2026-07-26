## Voici le quatrième fichier : guidelines.md. Ce document est ton guide de style et de méthode. Il assure que l'application ne soit pas seulement fonctionnelle, mais aussi belle, rapide et facile à maintenir.

4. FICHIER : guidelines.md
Ce document définit les standards visuels, techniques et organisationnels pour le développement de Negus Family.

4.1 Identité Visuelle (UI/UX)
L'objectif est de créer une atmosphère "Premium, Royale et Musicale".

Palette de Couleurs :

Primaire (Fond) : #0F172A (Bleu nuit très sombre / Ardoise) – Pour l'aspect moderne et immersif.

Secondaire (Accents) : #D4AF37 (Or/Gold) – Pour les boutons d'action (Acheter, S'abonner) et les titres importants.

Contraste : #FFFFFF (Blanc) pour le texte et #94A3B8 (Gris acier) pour les textes secondaires.

Typographie :

Titres : Montserrat (Sans-serif, gras) – Donne un aspect puissant et professionnel.

Corps de texte : Inter – Très lisible sur tous les écrans, particulièrement pour les listes de titres.

Composants :

Utiliser des cartes (Cards) avec un léger arrondi (rounded-xl) et des ombres douces.

État actif : Les boutons dorés doivent avoir un effet de surbrillance au survol (Hover).

4.2 Stack Technique & Pourquoi
Laravel 11 : Pour la robustesse des migrations, de l'authentification et de la gestion des fichiers sécurisés.

Livewire 3 : Indispensable pour ce projet. Il permet de créer le lecteur audio persistant (qui continue de jouer quand on change de page) et de gérer les filtres de recherche sans rechargement.

Tailwind CSS : Pour un design sur mesure ultra-rapide sans écrire de fichiers CSS séparés.

Alpine.js : Pour les micro-interactions (ouvrir une modale de paiement, menu mobile).

4.3 Gestion des Assets (Audios & Vidéos)
Stockage :

public/storage/demos : Fichiers MP3 compressés (128kbps) pour l'écoute gratuite.

storage/app/private/masters : Fichiers haute qualité (320kbps ou WAV) pour le téléchargement après achat.

Optimisation :

Utiliser la librairie FFMpeg (via un wrapper PHP) pour générer automatiquement l'aperçu de 30s à partir du fichier complet si possible. Sinon, forcer l'artiste à uploader les deux.

Images : Redimensionner systématiquement les pochettes d'albums en 500x500px pour éviter de ralentir le site.

4.4 Librairies Tierces Recommandées
FedaPay PHP SDK : Intégration directe pour le Mobile Money.

Spatie Media Library : Pour gérer les associations entre les modèles (Artistes/Titres) et leurs fichiers de manière propre.

FilamentPHP : (Recommandation Forte) Pour générer l'interface Admin de ton cousin en 30 minutes. Cela te permet de te concentrer sur le front-end.

Blade Icons : Pour intégrer facilement des icônes (Heroicons) pour le lecteur audio (Play, Pause, Next).

4.5 Principes de Développement (Data Driven)
Simplicité : Avant de créer une nouvelle table, demande-toi si un champ supplémentaire dans une table existante ne suffit pas.

Validation : Toujours valider les types de fichiers (mimes:mp3,wav,mp4) lors de l'upload pour éviter les failles de sécurité.

Mobile First : 90% des fans de musique en Afrique utiliseront l'application sur leur téléphone. L'interface doit être parfaite sur mobile avant d'être testée sur PC.