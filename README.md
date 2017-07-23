### Tech
* symfony
* composer
* mysql

# Installation !
  - Télécharger et décompreser le dossier dans:
     - ubuntu: /var/www/html/ 
     - windows : c:/wamp/www/
  - Accéder au dossier via le terminal et lancer la commande:
  
        - $ composer install
        - renseigner les paramètres de la base de données dans app/config/parameter.yml
        - php bin/console d:d:c
        - php bin/console d:s:update --force
  
  - Lancer l'application 
    1. via le terminal : acceder au dossier et executer 
          - php bin/console server:run
          - acceder à l'url : localhost:8000
    2. acceder directement à l url: localhost/nom_de_dossier/web/app.php/
  
  # fonctionnement 
  - Créer user : localhost:8000/register
  - Attribuer les roles : ( ROLE_ADMINISTRATEUR, ROLE_MAGASINIER, ROLE_RESPONSABLE) 
     * php bin/console fos:user:promote maga  ROLE_MAGASINIER

