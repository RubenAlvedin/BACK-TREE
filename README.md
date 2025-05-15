

# 🎯 Projet Symfony – Notification de changement de score

Ce projet Symfony Backend a pour objectif de **mettre en relation un Listener surveillant les changements de score d’un utilisateur** avec un **microservice externe de mailing**, permettant ainsi d’envoyer une notification par email à chaque mise à jour.

---

## 🧩 Fonctionnalités principales

* 🎧 **Listener `ScoreUpdateListener`**
  Écoute les changements du champ `score` sur l'entité `User`. Lorsqu'une mise à jour est détectée, une requête HTTP est envoyée vers un service externe de mailing (ex : `http://host.docker.internal:8001/send-score-change`).

* 📩 **Intégration d’un microservice Mailer externe**
  Communication via requêtes HTTP POST pour externaliser l’envoi de mails.

* 🔐 **Système d’authentification personnalisé**
  Implémentation manuelle de la gestion de tokens pour l'authentification, sans recours à JWT.
  👉 Ce choix respecte la consigne "utilisation d’un framework PHP de notre choix" et n’impacte pas les fonctionnalités d’inscription et de connexion.

* 👤 **Commandes personnalisées pour la création d'utilisateurs**
  Des commandes Symfony CLI permettent de créer un utilisateur directement via la console.

* ✅ **Assert personnalisés**
  Validation avancée des données grâce à des contraintes personnalisées sur les entités.

---

## 🚀 Lancer le projet en local

### Prérequis

* PHP 8.1+
* Composer
* Symfony CLI
* Docker (pour le microservice si nécessaire)
* Une base de données (MySQL ou autre)

### Installation

```bash
git clone https://github.com/votre-repo/mon-projet-symfony.git
cd mon-projet-symfony
composer install
cp .env.example .env
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
symfony server:start
```

---

## ⚙️ Commandes utiles

### Créer un utilisateur via CLI

```bash
php bin/console app:create-user
```

---

## 🔒 Authentification personnalisée

Le système d’authentification repose sur :

* une gestion de token propre (stocké et validé sans JWT)
* un endpoint de login générant un token
* un middleware vérifiant les tokens à chaque requête protégée

---

## 📦 Structure du projet

```
src/
├── Command/               # Commandes CLI personnalisées
├── Entity/                # Entités Doctrine
├── EventListener/         # Listener pour score
├── Security/              # Authentification custom
├── Service/               # Services (appel au microservice mailer)
└── Validator/             # Assert personnalisés
```

---

## ✍️ Remarques

> 💡 Ce projet respecte les contraintes pédagogiques en utilisant Symfony comme framework PHP principal, tout en proposant une implémentation personnalisée qui n’entrave pas les fonctionnalités d’inscription et de connexion classiques.

---

⚠️ Limitations

🔧 Note personnelle :
Je n’ai malheureusement pas réussi à faire fonctionner la communication entre le listener ScoreUpdateListener et le microservice mailer.
Néanmoins, j’ai proposé une configuration complète et documentée qui pourrait être fonctionnelle, avec une structure permettant facilement de corriger ou compléter le système.
