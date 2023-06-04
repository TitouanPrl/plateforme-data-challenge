# README
## Projet Data-Challenge pour IA Pau
### Table des matières
1. [Lancer le serveur PHP](#lancer-le-serveur-php)
2. [Lancer le serveur HTTP](#lancer-le-serveur-http)
3. [Initialiser la BDD](#initialiser-la-bdd)
4. [Ouvrir le site](#ouvrir-le-site)


#### Lancer le serveur PHP
***
Pour lancer le serveur :
```sh   
"php -S localhost:8002" dans le dossier qui contient le README.md
```

#### Lancer le serveur HTTP
***
Pour lancer le serveur JAVA :
```sh
"./launch.sh" dans le dossier analyseurServeur
```
Si vous n'avez pas les droits d'exécution :
```sh
"chmod +x launch.sh" dans le dossier analyseurServeur
```
Pour compiler les fichiers .java :
```sh
"ant compile" dans le dossier analyseurServeur
```
Pour générer la javadoc (pour l'ouvrir, ouvrir le fichier index.html dans le dossier doc):
```sh
"ant javadoc" dans le dossier analyseurServeur
```

#### Initialiser la BDD
***
Pour créer la BDD et l'initialiser :
```sh
"sudo mysql" dans le dossier sql, puis entrez votre mot de passe
"source siteprojet.sql;" 
```
Pour pouvoir utiliser la BDD sur le site :
```sh
Changer les identifiants de connexion dans le fichier bddData.php dans le dossier bdd
```

#### Ouvrir le site
***
```
"localhost:8002/php/General/accueilGeneral.php" dans votre navigateur
```


#### Crédits
***
---
Auteur :
    -CORNEC Dorian <cornecdori@cy-tech.fr>
    -DEPRETER Remi <depreterre@cy-tech.fr>
    -GALLOY Clémentine <galloyclem@cy-tech.fr>
    -LALLINEC Naiwann <lallinecna@cy-tech.fr>
    -PRADAL Titouan <pradaltito@cy-tech.fr>





