# Rémi DELECROIX

Site de galerie photos et vidéos

Ce projet utilise Symfony (v6.1.12) pour le développement d'une application web.

## Prérequis

- PHP version 8.2.4 ou supérieure
- Composer pour gérer les dépendances PHP
- Node.js version 14.x ou supérieure
- npm (livré avec Node.js) pour gérer les dépendances JavaScript
- MySQL ou un autre serveur de base de données compatible avec Symfony

## Installation

1. Clonez ce dépôt sur votre machine locale.
2. Assurez-vous d'avoir PHP et Composer installés.
3. Dans le répertoire du projet, exécutez la commande suivante pour installer les dépendances PHP :

   ```
   composer install
   ```

4. Assurez-vous d'avoir Node.js et npm installés.
5. Dans le répertoire du projet, exécutez la commande suivante pour installer les dépendances JavaScript :

   ```
   npm install
   ```

6. Créez une base de données MySQL pour l'application.
7. Créer un fichier `.env.local` et configurez les informations de connexion à la base de données dans ce fichier ainsi que l'environnement pour le dev (`APP_ENV=dev`)
8. Si vous n'avez pas de dump récent (voir dossier `data`), exécutez les migrations pour créer les tables de la base de données :

   ```
   php bin/console doctrine:migrations:migrate
   ```

9. Lancez le serveur de développement Symfony avec la commande suivante :

   ```
   symfony serve
   ```

10. Accédez à l'application dans votre navigateur à l'adresse `http://localhost:8000`.

11. Si besoin de générer de la data pour alimenter la BDD :

   ```
   php bin/console doctrine:fixture:load
   ```

12. Pour compiler le css et js (cf Makfile) :

   ```
   make Gulp
   ```

13. Générer des miniatures pour les images (cf Makfile) :

   ```
   make thumbs
   
