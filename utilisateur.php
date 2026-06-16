<h2 class="titre-page">Gestion : Utilisateurs</h2>

<?php
    require_once("modele/modele.php");

    // Droits de l'utilisateur connecte sur cette rubrique
    $monRole      = $_SESSION['RolesUtilisateur'];
    $peutModifier = in_array($monRole, array('Admin')); // ajout / modification / suppression
    $peutAjouter  = in_array($monRole, array('Admin')); // ajout (peut differer : ex. centre = Admin uniquement)

    // ----- Suppression (reservee aux roles autorises) -----
    if (isset($_GET['action'], $_GET['IdUtilisateur']) && $_GET['action'] === "sup") {
        if ($peutModifier) {
            deleteUtilisateur($_GET['IdUtilisateur']);
        } else {
            echo "<p class='message-erreur'>Vous n'avez pas le droit de supprimer.</p>";
        }
    }

    // ----- Traitement de la modification (reserve aux roles autorises) -----
    if (isset($_POST['modifier'])) {
        if ($peutModifier) {
            editUtilisateur($_POST['IdUtilisateur'], $_POST);
            echo "<p class='message-ok'>Modification enregistree.</p>";
        } else {
            echo "<p class='message-erreur'>Vous n'avez pas le droit de modifier.</p>";
        }
    }

    // ----- Traitement de l'ajout (reserve aux roles autorises) -----
    if (isset($_POST['Valider'])) {
        if ($peutAjouter) {
            insertUtilisateur($_POST);
            echo "<p class='message-ok'>Ajout enregistre.</p>";
        } else {
            echo "<p class='message-erreur'>Vous n'avez pas le droit d'ajouter.</p>";
        }
    }


    // ----- Formulaire de modification (si demande et autorise) -----
    if ($peutModifier && isset($_GET['action'], $_GET['IdUtilisateur']) && $_GET['action'] === "edit") {
        $ligne = selectUtilisateurParId($_GET['IdUtilisateur']);
        if ($ligne) {
            ?>
            <h3 class="titre-form">Modifier : Utilisateur #<?= htmlspecialchars($ligne['IdUtilisateur']) ?></h3>
            <form method="post" action="index.php?page=13" class="formulaire">
                <input type="hidden" name="IdUtilisateur" value="<?= htmlspecialchars($ligne['IdUtilisateur']) ?>">
                <table>
                <tr>
                    <td>Pseudonyme :</td>
                    <td><input type="text" name="PseudonymeUtilisateur" value="<?= htmlspecialchars($ligne['PseudonymeUtilisateur']) ?>"></td>
                </tr>
                <tr>
                    <td>E-mail :</td>
                    <td><input type="text" name="MailUtilisateur" value="<?= htmlspecialchars($ligne['MailUtilisateur']) ?>"></td>
                </tr>
                <tr>
                    <td>Mot de passe :</td>
                    <td><input type="password" name="MotDePasseUtilisateur" placeholder="(laisser vide pour ne pas changer)"></td>
                </tr>
                <tr>
                    <td>Rôle :</td>
                    <td><select name="RolesUtilisateur"><option value="Admin" <?= ($ligne['RolesUtilisateur'] === "Admin") ? "selected" : "" ?>>Admin</option><option value="Gerant" <?= ($ligne['RolesUtilisateur'] === "Gerant") ? "selected" : "" ?>>Gerant</option><option value="Client" <?= ($ligne['RolesUtilisateur'] === "Client") ? "selected" : "" ?>>Client</option></select></td>
                </tr>
                <tr>
                    <td>Prénom :</td>
                    <td><input type="text" name="PrenomUtilisateur" value="<?= htmlspecialchars($ligne['PrenomUtilisateur']) ?>"></td>
                </tr>
                <tr>
                    <td>Nom :</td>
                    <td><input type="text" name="NomUtilisateur" value="<?= htmlspecialchars($ligne['NomUtilisateur']) ?>"></td>
                </tr>
                <tr>
                    <td>Sexe :</td>
                    <td><select name="SexeUtilisateur"><option value="M" <?= ($ligne['SexeUtilisateur'] === "M") ? "selected" : "" ?>>M</option><option value="F" <?= ($ligne['SexeUtilisateur'] === "F") ? "selected" : "" ?>>F</option><option value="Autre" <?= ($ligne['SexeUtilisateur'] === "Autre") ? "selected" : "" ?>>Autre</option></select></td>
                </tr>
                <tr>
                    <td>Adresse :</td>
                    <td><input type="text" name="AdresseUtilisateur" value="<?= htmlspecialchars($ligne['AdresseUtilisateur']) ?>"></td>
                </tr>
                <tr>
                    <td>Code postal :</td>
                    <td><input type="text" name="CodePostalUtilisateur" value="<?= htmlspecialchars($ligne['CodePostalUtilisateur']) ?>"></td>
                </tr>
                <tr>
                    <td>Ville :</td>
                    <td><input type="text" name="VilleUtilisateur" value="<?= htmlspecialchars($ligne['VilleUtilisateur']) ?>"></td>
                </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="modifier" value="Modifier"></td>
                    </tr>
                </table>
            </form>
            <?php
        }
    }

    // ----- Formulaire d'ajout (si autorise) -----
    if ($peutAjouter) {
        require_once("vue/vue_insert_utilisateur.php");
    }

    // ----- Liste des enregistrements -----
    $lesLignes = selectAllUtilisateur();
    require_once("vue/vue_select_utilisateur.php");
?>
