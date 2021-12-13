# php-reseaux-sociaux
Site web agissant comme un réseau social assez classique avec des fonctionnalités en plu

# Réalisation

- Ce projet a été réalisé principalement en PHP côté back et HTML5/CSS3/JS Native/Bootstrap côté front
- Visual Studio Code comme éditeur de texte
- uWamp pour le serveur local
- MySQL / phpmyAdmin comme base de donnée

# Image en détail

## Page d'accueil
![accueil](https://user-images.githubusercontent.com/25708184/129237637-5300d96b-7daf-4210-8ac7-45eb03cb4a28.JPG)

**Les nom et prénom des utilisateurs en rouge dans les postes sont cliquables et redirige le visiteur dans le profil de l'utilisateur sélectionné.**


## Page de connexion
**Peut renvoyer une erreur si les identifiants ne sont pas correctes.**
![login](https://user-images.githubusercontent.com/25708184/129238917-c35bbcf8-6fca-444e-a6fc-30648f9cffad.JPG)


## Page d'inscription
**Peut renvoyer des erreurs si les données saisies ne sont pas correctes.**
**Les utilisateurs sont enregistrés bien évidemment dans une base de donnée.** 
![inscription](https://user-images.githubusercontent.com/25708184/129239348-cf4d69d6-adde-4a1d-806c-e31edfadbfa3.JPG)


## Page d'accueil en tant que connecté
**L'identifiant de l'utilisateur apparait comme entouré en rouge en haut à gauche de la fenêtre pour indiquer qu'il est bien connecté.**

**L'utilisateur peut donc désormais poster des commentaires sous une publication, aimé une publication et supprimer ses publications, toujours dans la page d'accueil.**
![connecter](https://user-images.githubusercontent.com/25708184/129239602-22f23f9f-bcd7-49a9-a6c5-b023642c86e2.JPG)

## Barre intéraction
**Lorsque l'on clique sur la barre "interaction" à gauche, elle affiche tous les amis de l'utilisateur connecté et lui permet d'envoyer des messages et consulter leur profil rapidement.**

![interaction](https://user-images.githubusercontent.com/25708184/129240747-79dd45a3-b4fa-49b9-828c-825873df436d.JPG)

## Message avec un ami
![chat](https://user-images.githubusercontent.com/25708184/129240868-a3634fb1-e23b-48fe-a3a0-674888b81241.JPG)

## Profil d'un utilisateur parmi tant d'autres
**Le profil de l'utilisateur sélectionné affiche :**
- l'identifiant
- sa dernière date de connexion 
- son nom et prénom
- une image de profil modifiable dans les paramètres du profil
- la fonctionnalité de l'ajouter en ami ou de le retirer comme ici présent
- ses amis
- sa description modifiable dans les paramètres du profil
- toutes les publications postés
- tous les commentaires postés sous une publication

![profilAmis](https://user-images.githubusercontent.com/25708184/129241102-f6af59dc-51b3-4b1d-8ca7-43abf0918583.JPG)

## Ami de l'utilisateur sélectionné
![amis](https://user-images.githubusercontent.com/25708184/129242551-36065916-a4cd-4a0b-baa5-8fb22babb8af.JPG)

## Barre de recherche (recherche uniquement les utilisateurs)
![recherche](https://user-images.githubusercontent.com/25708184/129243250-bb7aeeac-1617-40b7-aee1-b91eb40a387e.JPG)

## Paramètre en haut à droite lorsque connecté
![setting](https://user-images.githubusercontent.com/25708184/129243398-d37844f4-206b-4f95-9691-5c5e4a7c8bdc.JPG)

## - Lorsque l'on clique sur "Profil" dans le menu déroulant du Paramètre
**L'utilisateur connecté peut éditer son profil et consulter et interagir avec ses précédents publication / commentaires.**
![myprofil](https://user-images.githubusercontent.com/25708184/129243614-ea6f97a9-9bf0-44f4-aaf7-7876539dc149.JPG)

## - Editer le profil de l'utilisateur connecté
**Du JavaScript a été ajouté au niveau de la partie pour afficher en temps réel la nouvelle photo ajouté par l'utilisateur afin qu'il puisse visualiser le résultat en direct.**
![editerProfil](https://user-images.githubusercontent.com/25708184/129243872-74e8fdee-4c5d-4f3b-8c1c-8e46d4e6b681.JPG)

## - Lorsque l'on clique sur "Voir mes amis" dans le menu déroulant du Paramètre
![amiJdupont](https://user-images.githubusercontent.com/25708184/129244680-dd5d6389-c503-4464-914b-8a84d136a312.JPG)


## Voir la conversation (Accessible via Page d'accueil ou Profil)
**Conversation = publication sélectionnée + tous les commentaires liés.
Tous les commentaires liés à la publication sélectionnée sont affichés et trié du moins récent jusqu'au plus récent comme sur Instagram.**
**L'utilisateur connecté peut supprimer ses/son commentaire(s) lié(s) à la publication sélectionnée.** 
![seeThread](https://user-images.githubusercontent.com/25708184/129245480-b8562552-9db6-40c9-afec-e98d4201ff33.JPG)
