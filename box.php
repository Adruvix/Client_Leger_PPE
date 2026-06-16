<h2 class="titre-page">Gestion : Box</h2>

<?php
    require_once("modele/modele.php");

    // Droits de l'utilisateur connecte sur cette rubrique
    $monRole      = $_SESSION['RolesUtilisateur'];
    $peutModifier = in_array($monRole, array('Gerant', 'Admin')); // ajout / modification / suppression
    $peutAjouter  = in_array($monRole, array('Gerant', 'Admin')); // ajout (peut differer : ex. centre = Admin uniquement)

    // ----- Suppression (reservee aux roles autorises) -----
    if (isset($_GET['action'], $_GET['IdBox']) && $_GET['action'] === "sup") {
        if ($peutModifier) {
            deleteBox($_GET['IdBox']);
        } else {
            echo "<p class='message-erreur'>Vous n'avez pas le droit de supprimer.</p>";
        }
    }

    // ----- Traitement de la modification (reserve aux roles autorises) -----
    if (isset($_POST['modifier'])) {
        if ($peutModifier) {
            editBox($_POST['IdBox'], $_POST);
            echo "<p class='message-ok'>Modification enregistree.</p>";
        } else {
            echo "<p class='message-erreur'>Vous n'avez pas le droit de modifier.</p>";
        }
    }

    // ----- Traitement de l'ajout (reserve aux roles autorises) -----
    if (isset($_POST['Valider'])) {
        if ($peutAjouter) {
            $resBox = insertBox($_POST);
            if ($resBox['ok']) {
                echo "<p class='message-ok'>".htmlspecialchars($resBox['message'])."</p>";
            } else {
                echo "<p class='message-erreur'>".htmlspecialchars($resBox['message'])."</p>";
            }
        } else {
            echo "<p class='message-erreur'>Vous n'avez pas le droit d'ajouter.</p>";
        }
    }

    // Listes pour les menus deroulants (cles etrangeres)
    $lesChevaux = selectAllCheval();
    $lesTypesLogement = selectAllTypeLogement();
    $lesCentres = selectAllCentre();

    // ----- Formulaire de modification (si demande et autorise) -----
    if ($peutModifier && isset($_GET['action'], $_GET['IdBox']) && $_GET['action'] === "edit") {
        $ligne = selectBoxParId($_GET['IdBox']);
        if ($ligne) {
            ?>
            <h3 class="titre-form">Modifier : Box #<?= htmlspecialchars($ligne['IdBox']) ?></h3>
            <form method="post" action="index.php?page=4" class="formulaire">
                <input type="hidden" name="IdBox" value="<?= htmlspecialchars($ligne['IdBox']) ?>">
                <table>
                <tr>
                    <td>Numéro du box :</td>
                    <td><input type="number" name="NumBox" value="<?= htmlspecialchars($ligne['NumBox']) ?>"></td>
                </tr>
                <tr>
                    <td>Cheval (occupant) :</td>
                    <td><?php $cur = $ligne['IdCheval']; ?><select name="IdCheval"><option value="" <?= ($cur === "" || $cur === null) ? "selected" : "" ?>>-- Aucun --</option><?php mysqli_data_seek($lesChevaux, 0); foreach ($lesChevaux as $ligneFk) { $sel = ($ligneFk['IdCheval'] == $cur) ? "selected" : ""; echo "<option value='".$ligneFk['IdCheval']."' ".$sel.">".('#'.$ligneFk['IdCheval'].' - '.$ligneFk['NomCheval'])."</option>"; } ?></select></td>
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
        require_once("vue/vue_insert_box.php");
    }

    // ----- Liste des enregistrements -----
    $lesLignes = selectAllBox();
    require_once("vue/vue_select_box.php");
    // Statistiques des box par centre (vue v_box_stats_centre)
    echo "<h3 class='titre-form'>Statistiques des box par centre</h3>";
    $statsBox = selectStatsBox();
    echo "<table class='tableau'><tr><th>Centre</th><th>Box total</th><th>Box vides</th></tr>";
    foreach ($statsBox as $s) {
        echo "<tr><td>".htmlspecialchars($s['NomCentre'] ?? '')."</td>"
            ."<td>".htmlspecialchars($s['NbBoxTotal'] ?? '')."</td>"
            ."<td>".htmlspecialchars($s['NbBoxVides'] ?? '')."</td></tr>";
    }
    echo "</table>";
?>
