<?php
    session_start();
    require_once("modele/modele.php");

    // Si deja connecte, on va a l'accueil
    if (isset($_SESSION['IdUtilisateur'])) {
        header("Location: index.php");
        exit();
    }

    // Premier lancement : creation d'un administrateur par defaut
    if (compterUtilisateurs() === 0) {
        creerAdminParDefaut();
        $infoPremierLancement = true;
    }

    $erreur = "";
    if (isset($_POST['connexion'])) {
        $identifiant = $_POST['identifiant'] ?? '';
        $motDePasse  = $_POST['motdepasse'] ?? '';
        $utilisateur = verifierConnexion($identifiant, $motDePasse);
        if ($utilisateur) {
            $_SESSION['IdUtilisateur']          = $utilisateur['IdUtilisateur'];
            $_SESSION['PseudonymeUtilisateur']  = $utilisateur['PseudonymeUtilisateur'];
            $_SESSION['RolesUtilisateur']       = $utilisateur['RolesUtilisateur'];
            header("Location: index.php");
            exit();
        } else {
            $erreur = "Identifiants incorrects, ou compte desactive / bloque.";
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caballio - Connexion</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
</head>
<body class="page-login">

    <div class="carte-login">
        <div class="logo-titre">
            <span class="logo-caballio">&#9812;</span>
            <h1>Caballio</h1>
        </div>
        <p class="sous-titre">Connexion a votre espace</p>

        <?php if (!empty($erreur)) { ?>
            <p class="message-erreur"><?= htmlspecialchars($erreur) ?></p>
        <?php } ?>

        <?php if (!empty($infoPremierLancement)) { ?>
            <p class="message-info">
                Premier lancement : un compte administrateur a ete cree.<br>
                Identifiant : <strong>admin</strong> &mdash; Mot de passe : <strong>admin123</strong>
            </p>
        <?php } ?>

        <form method="post" class="formulaire-login">
            <label>Pseudonyme ou e-mail :</label>
            <input type="text" name="identifiant" required>

            <label>Mot de passe :</label>
            <input type="password" name="motdepasse" required>

            <input type="submit" name="connexion" value="Se connecter">
        </form>
    </div>

</body>
</html>
