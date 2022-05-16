# Built your Home



## Installation du projet

Après avoir copier ce repository sur votre serveur, il faut lancer la commande

```
composer install
```

puis il faut créer le fichier .env.local 

```
nano .env.local
```

dans ce fichier vous devez écrire la chaîne de connexion qui correspond à votre base de donnée

```
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7&charset=utf8mb4"
```

Il faut ensuite créer la base de donnée

```
bin/console doctrine:database:create
```

On va ensuite créer les tables

```
bin/console doctrine:migrations:migrate
```

puis nous allons populer cette BDD avec des données générés par fixture

```
bin/console d:f:l
```

Nous allons ensuite nous placer dans le dossier public pour créer le .htaccess

```
nano .htaccess
```

et copier ce code à l'intérieur

```
# Activer la réécriture d'url
RewriteEngine On

# Configuration de base de l'URL
RewriteCond %{REQUEST_URI}::$1 ^(/.+)/(.*)::\2$
RewriteRule ^(.*) - [E=BASE_URI:%1]

# Renvoie tout vers index.php
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ index.php?_url=/$1 [QSA,L]

RewriteCond %{HTTP:Authorization} ^(.*)
RewriteRule .* - [e=HTTP_AUTHORIZATION:%1]
```

Ensuite on génère nos clés pour le JWT Token

```
bin/console lexik:jwt:generate-keypair
```

## Routes d'API

L'ensemble de la documentation des routes d'api se trouve sur la route /api/doc
