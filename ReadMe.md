IUT Nancy-Charlemagne — BUT Informatique S3
Ressource Développement Web S3
Mini-Projet Deefy

Version adaptée 2026

Ce document décrit le rendu attendu pour le mini-projet Deefy, constitué principalement des fonctionnalités développées dans le cadre des TD pour l’application Deefy.

Rendu

Le projet est à rendre par binôme sous la forme :

D’un lien vers un dépôt Git ;
D’un tableau de bord listant les fonctionnalités réalisées ;
D’un script de création/remplissage de la base de données (si elle a été modifiée ou complétée) ;
D’éléments permettant le test de l’application, notamment les emails et mots de passe des utilisateurs créés.

Le projet doit de plus être installé sur le serveur webetu.iutnc.univ-lorraine.fr de façon à pouvoir être testé.

Fonctionnalités

Les fonctionnalités suivantes seront accessibles dans le menu d’accueil de l’application :

Mes playlists : affiche la liste des playlists enregistrées en base de données.

Afficher une playlist : chaque élément de la liste est cliquable et permet d’afficher une playlist qui devient la playlist courante stockée en session.

Ajouter une piste : ajoute une nouvelle piste à la playlist courante. Un formulaire est affiché pour saisir les données de la piste. Cette fonctionnalité est accessible dans l’affichage d’une playlist.

Créer une playlist vide : un formulaire permettant de saisir le nom d’une nouvelle playlist est affiché. À la validation, la playlist est créée et stockée en base de données ; elle devient la playlist courante.

Afficher la playlist courante : affiche la playlist stockée en session.

Important : il n'y a pas d'inscription ni d'authentification.

Compléments

Il est nécessaire de veiller scrupuleusement à la sécurité :
Stockage adéquat des mots de passe ;
Parades contre les injections XSS ;
Parades contre les injections SQL.
Le code HTML généré doit être valide.
L'utilisation d'un framework CSS pour la mise en page est autorisée.