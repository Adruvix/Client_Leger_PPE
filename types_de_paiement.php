<h2 class="titre-page">Gestion : Types de paiement</h2>

<?php
    require_once("modele/modele.php");

    // Droits de l'utilisateur connecte sur cette rubrique
    $monRole      = $_SESSION['RolesUtilisateur'];
    $peutModifier = in_array($monRole, array('Admin')); // ajout / modification / suppression
    $peutAjouter  = in_array($monRole, array('Admin')); // ajout (peut differer : ex. centre = Admin uniquement)

    // ----- Suppression (reservee aux roles autorises) -----
    if (isset($_GET['action'], $_GET['IdTypePayement']) && $_GET['action'] === "sup") {
        if ($peutModifier) {
            deleteTypePayement($_GET['IdTypePayement']);
        } else {
            echo "<p class='message-erreur'>Vous n'avez pas le droit de supprimer.</p>";
        }
    }

    // ----- Traitement de la modification (reserve aux roles autorises) -----
    if (isset($_POST['modifier'])) {
        if ($peutModifier) {
            editTypePayement($_POST['IdTypePayement'], $_POST);
            echo "<p class='message-ok'>Modification enregistree.</p>";
        } else {
            echo "<p class='message-erreur'>Vous n'avez pas le droit de modifier.</p>";
        }
    }

    // ----- Traitement de l'ajout (reserve aux roles autorises) -----
    if (isset($_POST['Valider'])) {
        if ($peutAjouter) {
            insertTypePayement($_POST);
            echo "<p class='message-ok'>Ajout enregistre.</p>";
        } else {
            echo "<p class='message-erreur'>Vous n'avez pas le droit d'ajouter.</p>";
        }
    }


    // ----- Formulaire de modification (si demande et autorise) -----
    if ($peutModifier && isset($_GET['action'], $_GET['IdTypePayement']) && $_GET['action'] === "edit") {
        $ligne = selectTypePayementParId($_GET['IdTypePayement']);
        if ($ligne) {
            ?>
            <h3 class="titre-form">Modifier : Type de paiement #<?= htmlspecialchars($ligne['IdTypePayement']) ?></h3>
            <form method="post" action="index.php?page=12" class="formulaire">
                <input type="hidden" name="IdTypePayement" value="<?= htmlspecialchars($ligne['IdTypePayement']) ?>">
                <table>
                <tr>
                    <td>Libellé :</td>
                    <td><input type="text" name="NomTypePayement" value="<?= htmlspecialchars($ligne['NomTypePayement']) ?>"></td>
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
        require_once("vue/vue_insert_types_de_paiement.php");
    }

    // ----- Liste des enregistrements -----
    $lesLignes = selectAllTypePayement();
    require_once("vue/vue_select_types_de_paiement.php");
?>
