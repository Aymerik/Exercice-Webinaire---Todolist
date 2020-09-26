# Webinaire | Exercice  2 : // Todo List
Correction de l'exercice // Todo List du webinaire.

## Présentation de l'exercice

Véritable fan des todo lists, vous cherchez à remplacer vos innombrables post-its par une page web vous permettant de gérer facilement les tâches que vous devez réaliser. Bonne nouvelle, pour votre outil, tout [le front](https://github.com/Aymerik/Exercice-Webinaire---Todolist--front) est déjà fait ! Il ne vous reste qu’à faire l’API permettant de faire fonctionner l’outil de Todolist.


Vous décidez de faire l’API avec Symfony. Pour faire fonctionner le front, vous allez devoir développer ces routes : 
* **GET /api/tasks**  
Permet de récupérer la liste des tâches à réaliser. Seuls l’id, le titre et le statut de la tâche seront renvoyées.  

* **GET /api/tasks/{id}**  
Permet de récupérer une tâche en particulier. Toutes les informations de la tâche seront renvoyées (id, titre, statut, description, date de création).  

* **POST /api/tasks**  
Permet de créer une tâche. Le titre et l’éventuelle description sont nécessaires pour la création d’une tâche.

* **PUT /api/tasks/{id}**  
Permet de modifier une tâche. Seuls le titre et le statut pourront être modifiés.

* **DELETE /api/tasks/{id}**  
Permet de supprimer définitivement une tâche.

Voici un exemple de tâche : 
```
{
    id: 1,
    title: “Faire une API avec Symfony”,
    done: false,
    description: “À faire avant de réaliser le projet 7”,
    createdAt: “2020-09-26T18:11:25+02:00”
}
```

## Installation

1. Clonez ou téléchargez le dépôt
2. Créez un fichier .env.local à la racine du dépôt contenant cette ligne : `DATABASE_URL=mysql://<login>:<password>@127.0.0.1:3306/<db name>?serverVersion=5.7`
3. Dans le dossier du projet, lancez les commandes :
    1. `composer install`
    2. `php bin/console doctrine:database:create` si votre base de données n'existe pas
    3. `php bin/console doctrine:migrations:migrate`
    4. `php bin/console doctrine:fixtures:load`
    5. `symfony server:start`
4. L'API est accessible à l'adresse `http://localhost:8000/api/tasks`
