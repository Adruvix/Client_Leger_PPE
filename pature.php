<h2 class="titre-page">Gestion : Pâtures</h2>

<?php
    require_once("modele/modele.php");

    // Droits de l'utilisateur connecte sur cette rubrique
    $monRole      = $_SESSION['RolesUtilisateur'];
    $peutModifier = in_array($monRole, array('Gerant', 'Admin')); // ajout / modification / suppression
    $peutAjouter  = in_array($monRole, array('Gerant', 'Admin')); // ajout (peut differer : ex. centre = Admin uniquement)

    // ----- Suppression (reservee aux roles autorises) -----
    if (isset($_GET['action'], $_GET['IdPature']) && $_GET['action'] === "sup") {
        if ($peutModifier) {
            deletePature($_GET['IdPature']);
        } else {
            echo "<p class='message-erreur'>Vous n'avez pas le droit de supprimer.</p>";
        }
    }

    // ----- Traitement de la modification (reserve aux roles autorises) -----
    if (isset($_POST['modifier'])) {
        if ($peutModifier) {
            editPature($_POST['IdPature'], $_POST);
            echo "<p class='message-ok'>Modification enregistree.</p>";
        } else {
            echo "<p class='message-erreur'>Vous n'avez pas le droit de modifier.</p>";
        }
    }

    // ----- Traitement de l'ajout (reserve aux roles autorises) -----
    if (isset($_POST['Valider'])) {
        if ($peutAjouter) {
            insertPature($_POST);
            echo "<p class='message-ok'>Ajout enregistre.</p>";
        } else {
            echo "<p class='message-erreur'>Vous n'avez pas le droit d'ajouter.</p>";
        }
    }

    // Listes pour les menus deroulants (cles etrangeres)
    $lesCentres = selectAllCentre();

    // ----- Formulaire de modification (si demande et autorise) -----
    if ($peutModifier && isset($_GET['action'], $_GET['IdPature']) && $_GET['action'] === "edit") {
        $ligne = selectPatureParId($_GET['IdPature']);
        if ($ligne) {
            ?>
            <h3 class="titre-form">Modifier : Pâture #<?= htmlspecialchars($ligne['IdPature']) ?></h3>
            <form method="post" action="index.php?page=3" class="formulaire">
                <input type="hidden" name="IdPature" value="<?= htmlspecialchars($ligne['IdPature']) ?>">
                <table>
                <tr>
                    <td>Nom de la pâture :</td>
                    <td><input type="text" name="NomPature" value="<?= htmlspecialchars($ligne['NomPature']) ?>"></td>
                </tr>
                <tr>
                    <td>Taille (m²) :</td>
                    <td><input type="number" step="0.01" name="TaillePature" value="<?= htmlspecialchars($ligne['TaillePature']) ?>"></td>
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
        require_once("vue/vue_insert_pature.php");
    }

    // ----- Liste des enregistrements -----
    $lesLignes = selectAllPature();
    require_once("vue/vue_select_pature.php");
?>
