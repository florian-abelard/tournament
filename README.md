# fl0 Tournoi

## Démarrage

### Pré-requis

* docker
* docker-compose (version 3)
* composer

### Mise en place de l'environnement

```bash
# Récupération des sources github
git clone https://github.com/florian-abelard/flo-tournoi.git

# Initialisation du projet
make init

# Démarrer les containers docker
make up

# Créer et alimenter la base de données
make db-init

# Afficher toutes les commandes disponibles
make
```

Accès interface sur `http://localhost`
