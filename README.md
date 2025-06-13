# Site internet de l'association Droit Au Vélo 

Ce dépôt de code contient le code PHP et SPIP nécéssaire au fonctionnement du site internet de l'association Droit de vélo. Il est basé sur la technologie Spip.

# Pré-requis

Pour lancer le serveur, il vous faut au préalable avoir installé :

- Le langage *PHP*
- Un serveur HTTP (*nginx* ou *Apache*)
- Une base de donnée (*MariaDB* ou *MySQL*)

Pour le téléchargement et la gestion des dépendances (librairie js), il vous
faut avoir installer *yarn* sur votre système.

# Installation en local


Récupérer le code avec Git :

```
git clone https://github.com/droitauvelo/squelette.git adav-site
```

Puis lancer le script d'installation (cela installera Spip en version 4.4 + plugins):

```
make install
```

# Activer les plugins

# Utilisation des librairies et outils (gulp et ses modules)

Lors du développement, quand vous souhaitez modifier les feuilles de styles ou
les js, n'oubliez pas de lancer gulp dans une console à part,
il s'occupera de compiler les fichiers à chaque modifications des
fichiers sources.

Pour savoir ce que fait exactement gulp, il suffit de lire
dans le fichier `squelettes/sources/Gulpfile.js`

```
cd squelettes/sources/
gulp
```

