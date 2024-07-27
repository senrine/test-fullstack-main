# Test Kalitics fullstack

## Prérequis
* Installer le CLI de symfony
* Préparer une base de donnée SQl (le projet a été créé avec mariaDB)


## Commandes à exécuter
```shell
# Adapter DATABASE_URL dans .env pour votre database SQL
composer install
php bin/console doctrine:migrations:migrate

# Pour démarrer le serveur local
symfony server:start
```


## Mise à jour du système de pointage
Ce projet a été mis à jour pour répondre à de nouvelles exigences fonctionnelles concernant le système de pointage des collaborateurs et des chefs de projet.
Principales modifications :


### Nouvelle structure de données
Création d'une entité ClockingDetail pour permettre plusieurs pointages par jour pour un même collaborateur.
Modification de l'entité Clocking pour supprimer les champs duration et clockingProject, remplacés par une relation OneToMany vers ClockingDetail.


### Formulaires de pointage
Création de deux nouveaux types de formulaire :

* CollaboratorClockingType : permet à un collaborateur de pointer sur plusieurs chantiers en une seule saisie.
* ManagerClockingType : permet à un chef de projet de pointer plusieurs collaborateurs sur les mêmes chantier en une seule saisie.


### Contrôleur et vues
Mise à jour du ClockingCollectionController pour gérer les deux nouveaux types de création de pointage.
Création de deux nouvelles vues Twig :

* create_collaborator.html.twig pour le formulaire collaborateur
* create_manager.html.twig pour le formulaire chef de projet


### JavaScript
Ajout de script pour gérer l'ajout dynamique de champs de pointage dans les formulaires.


### Migrations
Création d'une nouvelle migration pour mettre à jour la structure de la base de données.