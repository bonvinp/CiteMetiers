# CFPT - Cité des Métiers
## Configuration de Apache
Par défaut l'utilisateur d’exécution d'apache est __*www-data*__, ce qui pose un problème lors de l’exécution des scripts __*Python*__.
Pour corriger ce problème, il faut que Apache ait les droits équivalents à l'utilisateur __*pi*__ afin d'avoir les droits nécessaires.

Pour changer l'utilisateur par défaut, il faut se rendre dans le fichier __*envars*__ qui est présent dans le dossier __*/etc/apache2/*__. 

Une fois dans ce fichier, il faut éditer les lignes suivantes :
`export APACHE_RUN_USER=www-data`
`export APACHE_RUN_GROUP=www-data`

Par :
`export APACHE_RUN_USER=pi`
`export APACHE_RUN_GROUP=pi`

Une fois les lignes éditées, il suffit de sauvegarder et quitter et ensuite redémarrer apache avec la commande : 
`sudo service apache2 restart`