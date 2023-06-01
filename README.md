# README
## Projet Data-Challenge pour IA Pau
### Table des matières
1. [Lancer le serveur PHP](#lancer-le-serveur-php)
2. [Lancer le serveur HTTP](#lancer-le-serveur-http)
3. [Initialiser la BDD](#initialiser-la-bdd)] 


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


