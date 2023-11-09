## 6. Deployer un project Symfony

Dans cette section on explique comment deployer un projet Symfony

### 1. Testez le projet en local ###

Assurez-vous que le projet fonctionne d'abord en **local**:

La façon la plus simple de le faire est de : 

1. Cloner votre repo si vous ne l'avez pas encore en local
2. Lancer composer install
3. Installez webpack Encore

        composer require symfony/webpack-encore-bundle

4. Installez les dependences de webpack et compilez

        npm install
        npm run dev (ou npm run build)


5. Créer la BD et lancer les migrations (effacer le contenu du dossier src/Migrations si vous avez de conflits. Vous pouvez utiliser un fichier .bat)

        symfony console doctrine:database:drop 
        symfony console doctrine:database:create
        symfony console make:migration
        symfony console doctrine:migrations:migrate

6. Lancer les fixtures s'il y en a

        symfony console doctrine:fixtures:load

7. Testez l'app dans le navigateur avec le serveur de Symfony 

        symfony server:start


### 2. Utilisez git pour copier votre projet dans le serveur (hébergeur) ###

Vous avez un compte d'utilisateur (wad01, wad02...). 

Dans chaque compte il y a un dossier **public_html** qui contient un **project1**.
Ce projet contient la configuration d'un repo git qu'on utilisera pour pusher notre projet local.

## ATTENTION!!!!!: dans les instructions suivantes, changez TOUJOURS les références **wad01** par votre nom d'utilisateur 

Rajoutez ce repo comme remote:

    git remote add repo ssh://wad01@wad01.interface3.be/home/wad01/public_html/project1/repo.git

**Note**: pour comprendre cette ligne, lisez la **section 4.2 de ce document** dans sa totalité.

Faites un modification dans un fichier local (peu importe, un espace suffira... c'est juste pour que git detecte un changement dans le code pour créer un nouveau commit) et puis faites un commit en local et puis un push dans la branche **main**. Votre projet sera copié dans le dossier **project1** dans votre compte dans les serveur.

```
git add .
git commit -m "push production"
git push repo main
```

Repondez "yes" et tapez le password de votre utilisateur.

<br>


### 3. Lancez **composer install dans le dossier de votre serveur** et installez l'apache pack ###

**Ouvrez une session SSH** avec Putty pour vous connecter au serveur en console. Puis allez dans le dossier du projet dans le serveur:

        cd /home/wad01/public_html/project1

(adaptez le nom de l'utilisateur bien évidemment)

À partir de maintenant on travaillera de la même façon qu'en local (migrations, fixtures, webpack, etc...)

        composer install

Installez le module d'Apache pour Symfony, pour gérer la réécriture des URLs

        composer require symfony/apache-pack 


### 4. Si vous utilisez Webpack ###

Il faut ajuster le chemin où webpack cherchera vos assets compilés, car la configuration du serveur local de Symfony n'est pas la même que celle du serveur d'Interface3.

Vous pouvez éditer le fichier **en local** et puis faire push. Le changement à faire est::

```js
        // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    
    // .setPublicPath('/build') // commentez cette ligne!

    // dans le serveur d'Interface il faut ajuster le path
    .setPublicPath('/project1/public/build')
```

Puis, dans votre console .ssh (connexion avec putty déjà ouverte), vous devez installer les dépendances et compiler.

```
        cd /home/wad01/public_html/project1
```

... avec npm:

```
        npm install 
        npm run build
```
... **OU** avec yarn:

```
        yarn install
        yarn encore prod
```


### 5. Créez le fichier de paramètres de production env.local dans le serveur ###

Nous voulons configurer notre app avec les valeurs de production (vraie BD, user et password). Ces valeurs seront stockés **uniquement dans le serveur de production**. 

Par défaut, on sait que Symfony lit le fichier **.env** contenant des paramètres de base de notre projet (ex: connexion à la BD). 

Si vous mettez **les valeurs de production dans votre fichier** **.env** (ex: mots de pass) et vous pushez dans github, ces valeurs seront visibles par tout le monde dans github car le fichier .env est pushé!

Jetez un coup d'oeil au fichier .env de votre projet, Symfony ne peut pas le dire plus clair!

        # DO NOT DEFINE PRODUCTION SECRETS IN THIS FILE NOR IN ANY OTHER COMMITTED FILES.

Resumé : 

- ne mettez rien de sensible dans **.env** (les "vraies" valeurs des connexions, par exemple)
  
**Alors où est-ce qu'on met les identifiants sensibles (BD, mail...)?**

- pour mettre les valeurs sensibles **en production** une fois le projet se trouve dans le serveur, **créez un env.local dans le serveur**.
Le plus simple est de faire une copie du fichier .env vers .env.local et puis l'éditer avec l'éditeur *nano*.
Dans la console ssh tapez:

```
cp .env .env.local
nano .env.local 
```

Attention: le copiez-collez normal ne fonctionnera pas ici.

Modifiez la ligne contenant l'URL pour qu'elle corresponde à:

```
DATABASE_URL="mysql://wad01:DEMANDEZPASSWORDALADMIN@localhost:3306/db_wad01" 
```

Tapez CTRL-S (sauver) puis CTRL-X (fermer nano)

Attention à la réf. à wad01, changez-la. Si vous vous trompez dans l'edition, faites CTRL-X et NE SAUVEZ PAS LE BUFFER (tapez *non* puis ENTER)

#### Note optionnelle 

Si vous voulez tester votre projet en local (pas dans le serveur de production) mais en utilisant la BD de production, vous devriez faire les modifications correspondantes un fichier **env.local** aussi en local. Ce fichier est dans le .gitignore, il **n'est pas pushé**.

Pas besoin d'effacer .env car le fichier **.env.local** a la priorité sur **.env**. Juste ne mettez pas de valeurs sensibles à l'intérieur de **.env** (pass etc...)



### 6. Lancez la migration et les fixtures DANS LE SERVEUR (commandes de Symfony) ###

Dans la console SSH et dans le dossier de votre projet, tapez:

        rm migrations/V*
        symfony console d:d:drop --force
        symfony console d:d:create 
        symfony console make:migration
        symfony console doctrine:migrations:migrate
        symfony console doctrine:fixtures:load


### 7. Testez votre project en tapant l'URL ###

        Ex: wad01.interface3.be/project1/public


(à partir de maintenant, OPT)

### 8. Changer le mode de **dev** à **prod** dans le fichier **.env** du serveur ####

                APP_ENV=dev change à APP_ENV=prod

### 9. Créez un fichier contenant la totalité de la configuration de production dans le serveur ###

Dans la console: 

        cd /home/wad01/public_html/project1
        composer dump-env prod

Symfony crée un fichier .php contenant les paramètres contenus dans les fichiers .env et .env.local (en privilégiant ce dernier)

<br>

   
### 9. Préparer la cache

        symfony console cache:warmup --env=prod

Si vous obtenez une erreur, demandez à l'admin de vous rendre propriétaire de la totalité des dossiers de votre projet

### 10. Testez votre project en tapant l'URL (pas "index.php" ou "public"!) ###

        Ex: wad01.interface3.be/project1/public

<br>



