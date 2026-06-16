<?php
    session_start();
    require_once("modele/modele.php");

    // Acces protege : il faut etre connecte
    if (!isset($_SESSION['IdUtilisateur'])) {
        header("Location: login.php");
        exit();
    }
    $role = $_SESSION['RolesUtilisateur'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caballio</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
</head>
<body>

    <header>
        <div class="logo-titre">
            <span class="logo-caballio">&#9812;</span>
            <h1>Caballio</h1>
        </div>
        <p class="sous-titre">Gestion en ligne de centres equestres</p>
        <div class="bloc-utilisateur">
            <span>Connecte : <strong><?= htmlspecialchars($_SESSION['PseudonymeUtilisateur']) ?></strong> (<?= htmlspecialchars($role) ?>)</span>
            <a class="lien-deconnexion" href="logout.php">Deconnexion</a>
        </div>
    </header>

    <div class="conteneur">
        <nav>
            <?php if (true) { ?><a class="lien-nav" href="index.php?page=1">Accueil</a><?php } ?>
            <?php if (in_array($role, array('Gerant', 'Admin'))) { ?><a class="lien-nav" href="index.php?page=2">Centre</a><?php } ?>
            <?php if (in_array($role, array('Gerant', 'Admin'))) { ?><a class="lien-nav" href="index.php?page=3">Pâture</a><?php } ?>
            <?php if (in_array($role, array('Gerant', 'Admin'))) { ?><a class="lien-nav" href="index.php?page=4">Box</a><?php } ?>
            <?php if (in_array($role, array('Gerant', 'Admin'))) { ?><a class="lien-nav" href="index.php?page=5">Type de logement</a><?php } ?>
            <?php if (in_array($role, array('Client', 'Gerant', 'Admin'))) { ?><a class="lien-nav" href="index.php?page=6">Cheval</a><?php } ?>
            <?php if (in_array($role, array('Client', 'Gerant', 'Admin'))) { ?><a class="lien-nav" href="index.php?page=7">Équipement</a><?php } ?>
            <?php if (in_array($role, array('Admin'))) { ?><a class="lien-nav" href="index.php?page=8">Nourriture</a><?php } ?>
            <?php if (in_array($role, array('Client', 'Gerant', 'Admin'))) { ?><a class="lien-nav" href="index.php?page=9">Facture</a><?php } ?>
            <?php if (in_array($role, array('Admin'))) { ?><a class="lien-nav" href="index.php?page=10">Supplément</a><?php } ?>
            <?php if (in_array($role, array('Gerant', 'Admin'))) { ?><a class="lien-nav" href="index.php?page=11">Paiement</a><?php } ?>
            <?php if (in_array($role, array('Admin'))) { ?><a class="lien-nav" href="index.php?page=12">Type de paiement</a><?php } ?>
            <?php if (in_array($role, array('Admin'))) { ?><a class="lien-nav" href="index.php?page=13">Utilisateur</a><?php } ?>
        </nav>

        <main>
            <?php
                if (isset($_GET['page'])) {
                    $page = (int) $_GET['page'];
                } else {
                    $page = 1;
                }

                switch ($page) {
                    case 1 : require_once("home.php"); break;
                    case 2 : if (in_array($role, array('Gerant', 'Admin'))) { require_once("centre.php"); } else { echo "<h2>Acces refuse</h2><p>Droits insuffisants pour cette section.</p>"; } break;
                    case 3 : if (in_array($role, array('Gerant', 'Admin'))) { require_once("pature.php"); } else { echo "<h2>Acces refuse</h2><p>Droits insuffisants pour cette section.</p>"; } break;
                    case 4 : if (in_array($role, array('Gerant', 'Admin'))) { require_once("box.php"); } else { echo "<h2>Acces refuse</h2><p>Droits insuffisants pour cette section.</p>"; } break;
                    case 5 : if (in_array($role, array('Gerant', 'Admin'))) { require_once("types_de_logement.php"); } else { echo "<h2>Acces refuse</h2><p>Droits insuffisants pour cette section.</p>"; } break;
                    case 6 : if (in_array($role, array('Client', 'Gerant', 'Admin'))) { require_once("cheval.php"); } else { echo "<h2>Acces refuse</h2><p>Droits insuffisants pour cette section.</p>"; } break;
                    case 7 : if (in_array($role, array('Client', 'Gerant', 'Admin'))) { require_once("equipement.php"); } else { echo "<h2>Acces refuse</h2><p>Droits insuffisants pour cette section.</p>"; } break;
                    case 8 : if (in_array($role, array('Admin'))) { require_once("nourriture.php"); } else { echo "<h2>Acces refuse</h2><p>Droits insuffisants pour cette section.</p>"; } break;
                    case 9 : if (in_array($role, array('Client', 'Gerant', 'Admin'))) { require_once("facture.php"); } else { echo "<h2>Acces refuse</h2><p>Droits insuffisants pour cette section.</p>"; } break;
                    case 10 : if (in_array($role, array('Admin'))) { require_once("supplement.php"); } else { echo "<h2>Acces refuse</h2><p>Droits insuffisants pour cette section.</p>"; } break;
                    case 11 : if (in_array($role, array('Gerant', 'Admin'))) { require_once("paiement.php"); } else { echo "<h2>Acces refuse</h2><p>Droits insuffisants pour cette section.</p>"; } break;
                    case 12 : if (in_array($role, array('Admin'))) { require_once("types_de_paiement.php"); } else { echo "<h2>Acces refuse</h2><p>Droits insuffisants pour cette section.</p>"; } break;
                    case 13 : if (in_array($role, array('Admin'))) { require_once("utilisateur.php"); } else { echo "<h2>Acces refuse</h2><p>Droits insuffisants pour cette section.</p>"; } break;
                    default : require_once("home.php"); break;
                }
            ?>
        </main>
    </div>

    <footer>
        <p>2025 &copy; Caballio &mdash; Professionnals I.T. Projects</p>
    </footer>

</body>
</html>
