<h3 class="titre-form">Liste des Paiements</h3>

<table class="tableau">
    <tr>
        <th>ID</th>
        <th>Facture</th>
        <th>Montant</th>
        <th>Type de paiement</th>
        <th>Date paiement</th>
        <th>Date encaissement</th>
        <?php if ($peutModifier) { ?><th>Actions</th><?php } ?>
    </tr>

    <?php
    mysqli_data_seek($lesLignes, 0);
    foreach ($lesLignes as $ligne) {
        echo "<tr>";
            echo "<td>".htmlspecialchars($ligne['IdPayement'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($ligne['IdFacture'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($ligne['MontantPayement'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($ligne['IdTypePayement'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($ligne['DatePayement'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($ligne['DateEncaissementPayement'] ?? '')."</td>";
        if ($peutModifier) {
            echo "<td class='actions'>";
            echo "<a href='index.php?page=11&action=edit&IdPayement=".urlencode($ligne['IdPayement'])."' title='Modifier'>&#9998;</a> ";
            echo "<a href='index.php?page=11&action=sup&IdPayement=".urlencode($ligne['IdPayement'])."' title='Supprimer' onclick=\"return confirm('Confirmer la suppression ?');\">&#128465;</a>";
            echo "</td>";
        }
        echo "</tr>";
    }
    ?>
</table>
