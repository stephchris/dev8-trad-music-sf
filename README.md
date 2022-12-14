# Trad Music (Symfony)

## Étapes de création du projet

Générer le projet Symfony :

```shell
composer create-project symfony/skeleton:"6.1.*" trad-music-sf
```

OPTIONNEL : si on veut la totale (Doctrine, Twig, Security...) :

```shell
cd trad-music-sf
composer require webapp
```

Installation de Maker Bundle (pour générer du code PHP) :

```shell
composer require maker --dev
```

### Mise en place de la base de données

Installation de Doctrine :

```shell
composer require orm
```

Création du fichier .env.local :

```dotenv
DATABASE_URL="mysql://root:@127.0.0.1:3306/trad_music_sf?serverVersion=5.7&charset=utf8mb4"
```

Création de la base de données :

```shell
php bin/console doctrine:database:create
```

Création des entités :

```shell
php bin/console make:entity
```

## Installation du projet

Faire un fork du projet puis le cloner (git clone URL).

```shell
composer install
```

Création du fichier .env.local :

```dotenv
DATABASE_URL="mysql://root:@127.0.0.1:3306/trad_music_sf?serverVersion=5.7&charset=utf8mb4"
```

Création de la base de données :

```shell
php bin/console doctrine:database:create
```

OPTIONNEL : démarrer le serveur PHP (ou utiliser le serveur Apache de WAMP) :

```shell
php -S localhost:8000 -t public/
```