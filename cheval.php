<h2 class="titre-page">Gestion : Chevaux</h2>

<?php
    require_once("modele/modele.php");

    // Droits de l'utilisateur connecte sur cette rubrique
    $monRole      = $_SESSION['RolesUtilisateur'];
    $peutModifier = in_array($monRole, array('Gerant', 'Admin')); // ajout / modification / suppression
    $peutAjouter  = in_array($monRole, array('Gerant', 'Admin')); // ajout (peut differer : ex. centre = Admin uniquement)

    // ----- Suppression (reservee aux roles autorises) -----
    if (isset($_GET['action'], $_GET['IdCheval']) && $_GET['action'] === "sup") {
        if ($peutModifier) {
            deleteCheval($_GET['IdCheval']);
        } else {
            echo "<p class='message-erreur'>Vous n'avez pas le droit de supprimer.</p>";
        }
    }

    // ----- Traitement de la modification (reserve aux roles autorises) -----
    if (isset($_POST['modifier'])) {
        if ($peutModifier) {
            editCheval($_POST['IdCheval'], $_POST);
            echo "<p class='message-ok'>Modification enregistree.</p>";
        } else {
            echo "<p class='message-erreur'>Vous n'avez pas le droit de modifier.</p>";
        }
    }

    // ----- Traitement de l'ajout (reserve aux roles autorises) -----
    if (isset($_POST['Valider'])) {
        if ($peutAjouter) {
            insertCheval($_POST);
            echo "<p class='message-ok'>Ajout enregistre.</p>";
        } else {
            echo "<p class='message-erreur'>Vous n'avez pas le droit d'ajouter.</p>";
        }
    }

    // Listes pour les menus deroulants (cles etrangeres)
    $lesCentres = selectAllCentre();
    $lesClients = selectAllClients();

    // ----- Formulaire de modification (si demande et autorise) -----
    if ($peutModifier && isset($_GET['action'], $_GET['IdCheval']) && $_GET['action'] === "edit") {
        $ligne = selectChevalParId($_GET['IdCheval']);
        if ($ligne) {
            ?>
            <h3 class="titre-form">Modifier : Cheval #<?= htmlspecialchars($ligne['IdCheval']) ?></h3>
            <form method="post" action="index.php?page=6" class="formulaire">
                <input type="hidden" name="IdCheval" value="<?= htmlspecialchars($ligne['IdCheval']) ?>">
                <table>
                <tr>
                    <td>Nom du cheval :</td>
                    <td><input type="text" name="NomCheval" value="<?= htmlspecialchars($ligne['NomCheval']) ?>"></td>
                </tr>
                <tr>
                    <td>Sexe :</td>
                    <td><select name="SexeCheval"><option value="M" <?= ($ligne['SexeCheval'] === "M") ? "selected" : "" ?>>M</option><option value="F" <?= ($ligne['SexeCheval'] === "F") ? "selected" : "" ?>>F</option></select></td>
                </tr>
                <tr>
                    <td>Race :</td>
                    <td><input type="text" name="RaceCheval" value="<?= htmlspecialchars($ligne['RaceCheval']) ?>"></td>
                </tr>
                <tr>
                    <td>Centre :</td>
                    <td><?php $cur = $ligne['IdCentre']; ?><select name="IdCentre"><?php mysqli_data_seek($lesCentres, 0); foreach ($lesCentres as $ligneFk) { $sel = ($ligneFk['IdCentre'] == $cur) ? "selected" : ""; echo "<option value='".$ligneFk['IdCentre']."' ".$sel.">".('#'.$ligneFk['IdCentre'].' - '.$ligneFk['NomCentre'])."</option>"; } ?></select></td>
                </tr>
                <tr>
                    <td>Propriétaire (client) :</td>
                    <td><?php $cur = $ligne['IdClient']; ?><select name="IdClient"><?php mysqli_data_seek($lesClients, 0); foreach ($lesClients as $ligneFk) { $sel = ($ligneFk['IdClient'] == $cur) ? "selected" : ""; echo "<option value='".$ligneFk['IdClient']."' ".$sel.">".('#'.$ligneFk['IdClient'].' - '.$ligneFk['NomClient'])."</option>"; } ?></select></td>
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
        require_once("vue/vue_insert_cheval.php");
    }

    // ----- Liste des enregistrements -----
    $lesLignes = selectAllCheval();
    require_once("vue/vue_select_cheval.php");
?>
