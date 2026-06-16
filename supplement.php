<h2 class="titre-page">Gestion : Suppléments</h2>

<?php
    require_once("modele/modele.php");

    // Droits de l'utilisateur connecte sur cette rubrique
    $monRole      = $_SESSION['RolesUtilisateur'];
    $peutModifier = in_array($monRole, array('Admin')); // ajout / modification / suppression
    $peutAjouter  = in_array($monRole, array('Admin')); // ajout (peut differer : ex. centre = Admin uniquement)

    // ----- Suppression (reservee aux roles autorises) -----
    if (isset($_GET['action'], $_GET['IdSupplement']) && $_GET['action'] === "sup") {
        if ($peutModifier) {
            deleteSupplement($_GET['IdSupplement']);
        } else {
            echo "<p class='message-erreur'>Vous n'avez pas le droit de supprimer.</p>";
        }
    }

    // ----- Traitement de la modification (reserve aux roles autorises) -----
    if (isset($_POST['modifier'])) {
        if ($peutModifier) {
            editSupplement($_POST['IdSupplement'], $_POST);
            echo "<p class='message-ok'>Modification enregistree.</p>";
        } else {
            echo "<p class='message-erreur'>Vous n'avez pas le droit de modifier.</p>";
        }
    }

    // ----- Traitement de l'ajout (reserve aux roles autorises) -----
    if (isset($_POST['Valider'])) {
        if ($peutAjouter) {
            insertSupplement($_POST);
            echo "<p class='message-ok'>Ajout enregistre.</p>";
        } else {
            echo "<p class='message-erreur'>Vous n'avez pas le droit d'ajouter.</p>";
        }
    }

    // Listes pour les menus deroulants (cles etrangeres)
    $lesFactures = selectAllFacture();

    // ----- Formulaire de modification (si demande et autorise) -----
    if ($peutModifier && isset($_GET['action'], $_GET['IdSupplement']) && $_GET['action'] === "edit") {
        $ligne = selectSupplementParId($_GET['IdSupplement']);
        if ($ligne) {
            ?>
            <h3 class="titre-form">Modifier : Supplément #<?= htmlspecialchars($ligne['IdSupplement']) ?></h3>
            <form method="post" action="index.php?page=10" class="formulaire">
                <input type="hidden" name="IdSupplement" value="<?= htmlspecialchars($ligne['IdSupplement']) ?>">
                <table>
                <tr>
                    <td>Libellé :</td>
                    <td><input type="text" name="NomSupplement" value="<?= htmlspecialchars($ligne['NomSupplement']) ?>"></td>
                </tr>
                <tr>
                    <td>Prix (€) :</td>
                    <td><input type="number" step="0.01" name="PrixSupplement" value="<?= htmlspecialchars($ligne['PrixSupplement']) ?>"></td>
                </tr>
                <tr>
                    <td>Facture :</td>
                    <td><?php $cur = $ligne['IdFacture']; ?><select name="IdFacture"><?php mysqli_data_seek($lesFactures, 0); foreach ($lesFactures as $ligneFk) { $sel = ($ligneFk['IdFacture'] == $cur) ? "selected" : ""; echo "<option value='".$ligneFk['IdFacture']."' ".$sel.">".('#'.$ligneFk['IdFacture'])."</option>"; } ?></select></td>
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
        require_once("vue/vue_insert_supplement.php");
    }

    // ----- Liste des enregistrements -----
    $lesLignes = selectAllSupplement();
    require_once("vue/vue_select_supplement.php");
?>
