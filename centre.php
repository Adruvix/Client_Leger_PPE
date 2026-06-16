<h2 class="titre-page">Gestion : Centres</h2>

<?php
    require_once("modele/modele.php");

    // Droits de l'utilisateur connecte sur cette rubrique
    $monRole      = $_SESSION['RolesUtilisateur'];
    $peutModifier = in_array($monRole, array('Gerant', 'Admin')); // ajout / modification / suppression
    $peutAjouter  = in_array($monRole, array('Admin')); // ajout (peut differer : ex. centre = Admin uniquement)

    // ----- Suppression (reservee aux roles autorises) -----
    if (isset($_GET['action'], $_GET['IdCentre']) && $_GET['action'] === "sup") {
        if ($peutModifier) {
            deleteCentre($_GET['IdCentre']);
        } else {
            echo "<p class='message-erreur'>Vous n'avez pas le droit de supprimer.</p>";
        }
    }

    // ----- Traitement de la modification (reserve aux roles autorises) -----
    if (isset($_POST['modifier'])) {
        if ($peutModifier) {
            editCentre($_POST['IdCentre'], $_POST);
            echo "<p class='message-ok'>Modification enregistree.</p>";
        } else {
            echo "<p class='message-erreur'>Vous n'avez pas le droit de modifier.</p>";
        }
    }

    // ----- Traitement de l'ajout (reserve aux roles autorises) -----
    if (isset($_POST['Valider'])) {
        if ($peutAjouter) {
            insertCentre($_POST);
            echo "<p class='message-ok'>Ajout enregistre.</p>";
        } else {
            echo "<p class='message-erreur'>Vous n'avez pas le droit d'ajouter.</p>";
        }
    }

    // Listes pour les menus deroulants (cles etrangeres)
    $lesUtilisateurs = selectAllUtilisateur();

    // ----- Formulaire de modification (si demande et autorise) -----
    if ($peutModifier && isset($_GET['action'], $_GET['IdCentre']) && $_GET['action'] === "edit") {
        $ligne = selectCentreParId($_GET['IdCentre']);
        if ($ligne) {
            ?>
            <h3 class="titre-form">Modifier : Centre #<?= htmlspecialchars($ligne['IdCentre']) ?></h3>
            <form method="post" action="index.php?page=2" class="formulaire">
                <input type="hidden" name="IdCentre" value="<?= htmlspecialchars($ligne['IdCentre']) ?>">
                <table>
                <tr>
                    <td>Nom du centre :</td>
                    <td><input type="text" name="NomCentre" value="<?= htmlspecialchars($ligne['NomCentre']) ?>"></td>
                </tr>
                <tr>
                    <td>Adresse :</td>
                    <td><input type="text" name="AdresseCentre" value="<?= htmlspecialchars($ligne['AdresseCentre']) ?>"></td>
                </tr>
                <tr>
                    <td>Code postal :</td>
                    <td><input type="text" name="CPCentre" value="<?= htmlspecialchars($ligne['CPCentre']) ?>"></td>
                </tr>
                <tr>
                    <td>Ville :</td>
                    <td><input type="text" name="VilleCentre" value="<?= htmlspecialchars($ligne['VilleCentre']) ?>"></td>
                </tr>
                <tr>
                    <td>Téléphone :</td>
                    <td><input type="text" name="TelCentre" value="<?= htmlspecialchars($ligne['TelCentre']) ?>"></td>
                </tr>
                <tr>
                    <td>Gérant :</td>
                    <td><?php $cur = $ligne['IdGerant']; ?><select name="IdGerant"><option value="" <?= ($cur === "" || $cur === null) ? "selected" : "" ?>>-- Aucun --</option><?php mysqli_data_seek($lesUtilisateurs, 0); foreach ($lesUtilisateurs as $ligneFk) { $sel = ($ligneFk['IdUtilisateur'] == $cur) ? "selected" : ""; echo "<option value='".$ligneFk['IdUtilisateur']."' ".$sel.">".('#'.$ligneFk['IdUtilisateur'].' - '.$ligneFk['PseudonymeUtilisateur'])."</option>"; } ?></select></td>
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
        require_once("vue/vue_insert_centre.php");
    }

    // ----- Liste des enregistrements -----
    $lesLignes = selectAllCentre();
    require_once("vue/vue_select_centre.php");
?>
