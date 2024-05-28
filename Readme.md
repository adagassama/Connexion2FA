# Project Connexion 2FA avec Laravel et VueJS

Ce projet implémente un système d'authentification sécurisé avec une authentification à deux facteurs (2FA) utilisant Google Authenticator. Il utilise LARAVEL pour le backend et VueJS pour le frontend.L'application garantit des pratiques de sécurité robustes pour se protéger contre les attaques courantes comme les injections SQL.

## Tables des matières

- [Project Connexion 2FA avec Laravel et VueJS](#project-connexion-2fa-avec-laravel-et-vuejs)
  - [Tables des matières](#tables-des-matières)
  - [Fonctionnlités](#fonctionnlités)
  - [Prérequis](#prérequis)
  - [Installation](#installation)
    - [Backend (Laravel)](#backend-laravel)

## Fonctionnlités

- **Inscription des utilisateurs** : Inscription sécuriée des utilisateurs avec validation.
- **Connexion des utilisateurs** : Système de connexion sécurisé.
- **Authentification à deux facteurs (2FA)** : Intégration de Google Authenticator pour une sécurité renforcée.

## Prérequis

Il faut installer les prérequis avant de lancer le projet.

- [Node.js](https://nodejs.org/)
- [Composer](https://getcomposer.org/)
- [Laravel](version 10.48.11)
- [Vue 3](version)

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
    DB_DATABASE=/chemin/vers/votre/Connexion2FA/Backend/database/database.sqlite
    ```
