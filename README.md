# Caballio — Site de gestion de centres équestres

Application PHP/MySQL construite sur la **même organisation que le site AirFrance** :
un `index.php` central (header + menu latéral + `switch` qui inclut chaque page + footer),
une couche `modele/` et des vues `vue/` (un `vue_insert_X` et un `vue_select_X` par entité).

## Installation

1. Démarrer un serveur PHP + MySQL (ex. WAMP / XAMPP / MAMP).
2. Importer la base : `sql/Caballio_2.0.sql`.
   - (Optionnel) importer aussi `sql/donnees_exemple.sql` pour des données de test.
3. Placer le dossier dans le répertoire web (ex. `www/` ou `htdocs/`).
4. Vérifier les identifiants MySQL dans `modele/modele.php` (fonction `connexion()`).
   Par défaut : serveur `localhost`, base `centre_equestre`, user `root`, mot de passe vide.
5. Ouvrir `login.php` dans le navigateur.

## Connexion

Au premier lancement (table `utilisateur` vide), un compte administrateur est créé
automatiquement : identifiant **admin**, mot de passe **admin123**.
Les mots de passe sont stockés hachés (`password_hash` / `password_verify`).

## Rôles et accès (cahier des charges)

- **Client (A1)** : Cheval, Équipement, Facture — en **lecture seule** (ni ajout, ni
  modification, ni suppression ; la colonne « Actions » est masquée).
- **Gérant (A2)** : Centre, Pâture, Box, Type de logement, Cheval, Équipement, Facture,
  Paiement — consultation, modification et suppression.
- **Administrateur (A3)** : toutes les rubriques (dont Nourriture, Supplément, Type de
  paiement, Utilisateur).
- **Ajout d'un centre** : réservé à l'administrateur (contrainte C1).

Le menu et l'accès direct par URL sont contrôlés, et chaque page vérifie les droits
côté serveur via `$peutModifier` / `$peutAjouter`.

## Objets de la base utilisés par le site

- **Vue `v_facture_resume`** : la page Facture liste les factures avec le montant payé
  et le **restant à payer** par facture.
- **Vue `v_total_restant_global`** : la page Facture affiche le **total restant à payer**
  tous clients confondus.
- **Vue `v_box_stats_centre`** : la page Box affiche le **nombre de box total et vides**
  par centre.
- **Procédure `sp_maj_montant_facture`** (qui utilise la fonction
  **`fn_total_supplements`**) : le `MontantTotal` d'une facture est recalculé
  (prix du logement + suppléments) à la création/modification d'une facture et à
  l'ajout / modification / suppression d'un supplément.
- **Trigger `trg_verif_cheval_centre_insert`** : à l'ajout d'un box, si le cheval
  appartient à un autre centre, l'insertion est refusée et le **message d'erreur du
  trigger est affiché proprement** à l'utilisateur.

## Structure

```
index.php            Hub (menu selon le rôle + switch)
login.php / logout.php
home.php             Contenu de l'accueil
modele/modele.php    connexion(), authentification, CRUD, vues et procédure
vue/vue_insert_*.php Formulaires d'ajout
vue/vue_select_*.php Tableaux de liste (Modifier / Supprimer selon droits)
<entite>.php         Page de chaque entité
css/style.css        Charte vert foncé / blanc, menu latéral, responsive
sql/                 Schéma + données d'exemple optionnelles
```

## Remarque

La table `client` (référencée par cheval, équipement, facture) n'a pas de page dédiée
car non demandée ; `selectAllClients()` alimente les listes déroulantes.
