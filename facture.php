<h2 class="titre-page">Gestion : Factures</h2>

<?php
    require_once("modele/modele.php");

    // Droits de l'utilisateur connecte sur cette rubrique
    $monRole      = $_SESSION['RolesUtilisateur'];
    $peutModifier = in_array($monRole, array('Gerant', 'Admin')); // ajout / modification / suppression
    $peutAjouter  = in_array($monRole, array('Gerant', 'Admin')); // ajout (peut differer : ex. centre = Admin uniquement)

    // ----- Suppression (reservee aux roles autorises) -----
    if (isset($_GET['action'], $_GET['IdFacture']) && $_GET['action'] === "sup") {
        if ($peutModifier) {
            deleteFacture($_GET['IdFacture']);
        } else {
            echo "<p class='message-erreur'>Vous n'avez pas le droit de supprimer.</p>";
        }
    }

    // ----- Traitement de la modification (reserve aux roles autorises) -----
    if (isset($_POST['modifier'])) {
        if ($peutModifier) {
            editFacture($_POST['IdFacture'], $_POST);
            echo "<p class='message-ok'>Modification enregistree.</p>";
        } else {
            echo "<p class='message-erreur'>Vous n'avez pas le droit de modifier.</p>";
        }
    }

    // ----- Traitement de l'ajout (reserve aux roles autorises) -----
    if (isset($_POST['Valider'])) {
        if ($peutAjouter) {
            insertFacture($_POST);
            echo "<p class='message-ok'>Ajout enregistre.</p>";
        } else {
            echo "<p class='message-erreur'>Vous n'avez pas le droit d'ajouter.</p>";
        }
    }

    // Listes pour les menus deroulants (cles etrangeres)
    $lesClients = selectAllClients();
    $lesChevaux = selectAllCheval();
    $lesTypesLogement = selectAllTypeLogement();
    $lesCentres = selectAllCentre();

    // ----- Formulaire de modification (si demande et autorise) -----
    if ($peutModifier && isset($_GET['action'], $_GET['IdFacture']) && $_GET['action'] === "edit") {
        $ligne = selectFactureParId($_GET['IdFacture']);
        if ($ligne) {
            ?>
            <h3 class="titre-form">Modifier : Facture #<?= htmlspecialchars($ligne['IdFacture']) ?></h3>
            <form method="post" action="index.php?page=9" class="formulaire">
                <input type="hidden" name="IdFacture" value="<?= htmlspecialchars($ligne['IdFacture']) ?>">
                <table>
                <tr>
                    <td>Date du bail :</td>
                    <td><input type="date" name="DateBail" value="<?= htmlspecialchars($ligne['DateBail']) ?>"></td>
                </tr>
                <tr>
                    <td>Client :</td>
                    <td><?php $cur = $ligne['IdClient']; ?><select name="IdClient"><?php mysqli_data_seek($lesClients, 0); foreach ($lesClients as $ligneFk) { $sel = ($ligneFk['IdClient'] == $cur) ? "selected" : ""; echo "<option value='".$ligneFk['IdClient']."' ".$sel.">".('#'.$ligneFk['IdClient'].' - '.$ligneFk['NomClient'])."</option>"; } ?></select></td>
                </tr>
                <tr>
                    <td>Cheval :</td>
                    <td><?php $cur = $ligne['IdCheval']; ?><select name="IdCheval"><?php mysqli_data_seek($lesChevaux, 0); foreach ($lesChevaux as $ligneFk) { $sel = ($ligneFk['IdCheval'] == $cur) ? "selected" : ""; echo "<option value='".$ligneFk['IdCheval']."' ".$sel.">".('#'.$ligneFk['IdCheval'].' - '.$ligneFk['NomCheval'])."</option>"; } ?></select></td>
                </tr>
                <tr>
                    <td>Type de logement :</td>
                    <td><?php $cur = $ligne['IdTypeLogement']; ?><select name="IdTypeLogement"><?php mysqli_data_seek($lesTypesLogement, 0); foreach ($lesTypesLogement as $ligneFk) { $sel = ($ligneFk['IdTypeLogement'] == $cur) ? "selected" : ""; echo "<option value='".$ligneFk['IdTypeLogement']."' ".$sel.">".('#'.$ligneFk['IdTypeLogement'].' - '.$ligneFk['NomTypeLogement'])."</option>"; } ?></select></td>
                </tr>
                <tr>
                    <td>Centre :</td>
                    <td><?php $cur = $ligne['IdCentre']; ?><select name="IdCentre"><?php mysqli_data_seek($lesCentres, 0); foreach ($lesCentres as $ligneFk) { $sel = ($ligneFk['IdCentre'] == $cur) ? "selected" : ""; echo "<option value='".$ligneFk['IdCentre']."' ".$sel.">".('#'.$ligneFk['IdCentre'].' - '.$ligneFk['NomCentre'])."</option>"; } ?></select></td>
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
        require_once("vue/vue_insert_facture.php");
    }

    // ----- Liste des enregistrements -----
    $lesLignes = selectResumeFactures();
    require_once("vue/vue_select_facture.php");
    // Total restant a payer (vue v_total_restant_global)
    $totalRestant = selectTotalRestantGlobal();
    echo "<p class='message-info'>Total restant a payer (tous clients confondus) : <strong>"
        .htmlspecialchars(number_format((float)$totalRestant, 2, ',', ' '))." &euro;</strong></p>";
?>
