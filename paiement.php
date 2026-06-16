<h2 class="titre-page">Gestion : Paiements</h2>

<?php
    require_once("modele/modele.php");

    // Droits de l'utilisateur connecte sur cette rubrique
    $monRole      = $_SESSION['RolesUtilisateur'];
    $peutModifier = in_array($monRole, array('Gerant', 'Admin')); // ajout / modification / suppression
    $peutAjouter  = in_array($monRole, array('Gerant', 'Admin')); // ajout (peut differer : ex. centre = Admin uniquement)

    // ----- Suppression (reservee aux roles autorises) -----
    if (isset($_GET['action'], $_GET['IdPayement']) && $_GET['action'] === "sup") {
        if ($peutModifier) {
            deletePayement($_GET['IdPayement']);
        } else {
            echo "<p class='message-erreur'>Vous n'avez pas le droit de supprimer.</p>";
        }
    }

    // ----- Traitement de la modification (reserve aux roles autorises) -----
    if (isset($_POST['modifier'])) {
        if ($peutModifier) {
            editPayement($_POST['IdPayement'], $_POST);
            echo "<p class='message-ok'>Modification enregistree.</p>";
        } else {
            echo "<p class='message-erreur'>Vous n'avez pas le droit de modifier.</p>";
        }
    }

    // ----- Traitement de l'ajout (reserve aux roles autorises) -----
    if (isset($_POST['Valider'])) {
        if ($peutAjouter) {
            insertPayement($_POST);
            echo "<p class='message-ok'>Ajout enregistre.</p>";
        } else {
            echo "<p class='message-erreur'>Vous n'avez pas le droit d'ajouter.</p>";
        }
    }

    // Listes pour les menus deroulants (cles etrangeres)
    $lesFactures = selectAllFacture();
    $lesTypesPayement = selectAllTypePayement();

    // ----- Formulaire de modification (si demande et autorise) -----
    if ($peutModifier && isset($_GET['action'], $_GET['IdPayement']) && $_GET['action'] === "edit") {
        $ligne = selectPayementParId($_GET['IdPayement']);
        if ($ligne) {
            ?>
            <h3 class="titre-form">Modifier : Paiement #<?= htmlspecialchars($ligne['IdPayement']) ?></h3>
            <form method="post" action="index.php?page=11" class="formulaire">
                <input type="hidden" name="IdPayement" value="<?= htmlspecialchars($ligne['IdPayement']) ?>">
                <table>
                <tr>
                    <td>Date du paiement :</td>
                    <td><input type="date" name="DatePayement" value="<?= htmlspecialchars($ligne['DatePayement']) ?>"></td>
                </tr>
                <tr>
                    <td>Date d'encaissement :</td>
                    <td><input type="date" name="DateEncaissementPayement" value="<?= htmlspecialchars($ligne['DateEncaissementPayement']) ?>"></td>
                </tr>
                <tr>
                    <td>Montant (€) :</td>
                    <td><input type="number" step="0.01" name="MontantPayement" value="<?= htmlspecialchars($ligne['MontantPayement']) ?>"></td>
                </tr>
                <tr>
                    <td>Facture :</td>
                    <td><?php $cur = $ligne['IdFacture']; ?><select name="IdFacture"><?php mysqli_data_seek($lesFactures, 0); foreach ($lesFactures as $ligneFk) { $sel = ($ligneFk['IdFacture'] == $cur) ? "selected" : ""; echo "<option value='".$ligneFk['IdFacture']."' ".$sel.">".('#'.$ligneFk['IdFacture'])."</option>"; } ?></select></td>
                </tr>
                <tr>
                    <td>Type de paiement :</td>
                    <td><?php $cur = $ligne['IdTypePayement']; ?><select name="IdTypePayement"><?php mysqli_data_seek($lesTypesPayement, 0); foreach ($lesTypesPayement as $ligneFk) { $sel = ($ligneFk['IdTypePayement'] == $cur) ? "selected" : ""; echo "<option value='".$ligneFk['IdTypePayement']."' ".$sel.">".('#'.$ligneFk['IdTypePayement'].' - '.$ligneFk['NomTypePayement'])."</option>"; } ?></select></td>
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
        require_once("vue/vue_insert_paiement.php");
    }

    // ----- Liste des enregistrements -----
    $lesLignes = selectAllPayement();
    require_once("vue/vue_select_paiement.php");
?>
