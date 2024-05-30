# Connexion 2FA avec Laravel et VueJS

Ce projet implémente un système d'authentification sécurisé avec une authentification à deux facteurs (2FA) utilisant Google Authenticator. Il utilise LARAVEL pour le backend et VueJS pour le frontend. L'application garantit des pratiques de sécurité robustes pour se protéger contre les attaques courantes comme les injections SQL.

## Table des matières
- [Connexion 2FA avec Laravel et VueJS](#connexion-2fa-avec-laravel-et-vuejs)
  - [Table des matières](#table-des-matières)
  - [Fonctionnalités](#fonctionnalités)
  - [Prérequis](#prérequis)
  - [Installation](#installation)
    - [Backend (Laravel)](#backend-laravel)
    - [Frontend (VueJS)](#frontend-vuejs)
  - [Utilisation](#utilisation)
  - [Tests Backend](#tests-backend)

## Fonctionnalités

- **Inscription des utilisateurs** : Inscription sécuriée des utilisateurs avec validation.
- **Connexion des utilisateurs** : Système de connexion sécurisé.
- **Authentification à deux facteurs (2FA)** : Intégration de Google Authenticator pour une sécurité renforcée.

## Prérequis

Il faut installer les prérequis avant de lancer le projet.

- [Node.js](https://nodejs.org/)
- [Composer](https://getcomposer.org/)

## Installation

### Backend (Laravel)
1. **Cloner le projet:**
    ```bash
    git clone https://github.com/adagassama/Connexion2FA.git
    cd Connexion2FA/Backend
    ```
2. **Installer les dépendances:**
    ```bash
    composer install
    ```
3. **Configurez le fichier `.env`:**
    ```env
    DB_CONNECTION=sqlite
    DB_DATABASE=/chemin/vers/votre/dossier/Connexion2FA/Backend/database/database.sqlite
    ```
4. **Créer le fichier SQLite:**
    ```bash
    touch database/database.sqlite
    ```
5. **Exécuter les migrations:**
    ```bash
    php artisan migrate
    ```
6. **Lancer le serveur:**
    ```bash
    php artisan serve
    ```
### Frontend (VueJS)

1. **Installer les dépendances npm:**
    ```bash
    cd ../Frontend
    npm install
2. **Lancer le serveur de développement VueJS:**
    ```bash
    npm run dev
    ```
## Utilisation
- Accéder à `http://localhost:5173/` dans votre navigateur pour voir l'application en action.
- Inscrivez-vous, connectez-vous et suivez les instructions pour configurer l'authentification à deux facteurs.

## Tests Backend 
- **lancer les tests:**
    ```bash
    cd Backend
    php artisan test
    ```