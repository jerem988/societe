<u>Mode de déploiement</u>

- Outil nécéssaires pour faire tourner l'application:

	- Une plateforme de développement Web comportant PHP >=PHP 7.2.5, Apache et MySQL >= 5.7
		=> Exemple: Wamp, Mamp, Xamp
	- composer
	- un invité de ligne de commande en mode console
		=> Ex cmd, terminal, POWERSHELL
	- un accès internet

- Migrer l'application sur son pc en local:

	1 - Cloner le répertoire du git avec la commande une commande git clone "https://url_du_git"
	
	2 - Renseigner sa configuration, notamment la partie connection à la base de donnée dans le fichier .env ou créér un fichier .env.local pour une configuration 
	en local.
	
	3 - Dans un invité de commande se positionner à la racine du projet et lancer les commandes suivantes:
	
		- composer install
		- php bin/console doctrine:database:create (Créér sa base de données en local)
		- php bin/console doctrine:migrations:migrate
		- symfony server:start

	4 - L'adresse racine du serveur web s'affiche en vert exemple: "http://127.0.0.1:8000", se rendre à cette adresse

Une fois sur l'application, pour créér une société il faut cliquer sur le boutton "+" en vert.
