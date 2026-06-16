<h3 class="titre-form">Liste des Factures</h3>

<table class="tableau">
    <tr>
        <th>ID</th>
        <th>Client</th>
        <th>Cheval</th>
        <th>Type de logement</th>
        <th>Date du bail</th>
        <th>Montant total</th>
        <th>Payé</th>
        <th>Restant à payer</th>
        <th>Date d'ajout</th>
        <?php if ($peutModifier) { ?><th>Actions</th><?php } ?>
    </tr>

    <?php
    mysqli_data_seek($lesLignes, 0);
    foreach ($lesLignes as $ligne) {
        echo "<tr>";
            echo "<td>".htmlspecialchars($ligne['IdFacture'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($ligne['IdClient'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($ligne['IdCheval'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($ligne['IdTypeLogement'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($ligne['DateBail'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($ligne['MontantTotal'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($ligne['PaiementTotal'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($ligne['PaiementRestant'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($ligne['DateAjoutFacture'] ?? '')."</td>";
        if ($peutModifier) {
            echo "<td class='actions'>";
            echo "<a href='index.php?page=9&action=edit&IdFacture=".urlencode($ligne['IdFacture'])."' title='Modifier'>&#9998;</a> ";
            echo "<a href='index.php?page=9&action=sup&IdFacture=".urlencode($ligne['IdFacture'])."' title='Supprimer' onclick=\"return confirm('Confirmer la suppression ?');\">&#128465;</a>";
            echo "</td>";
        }
        echo "</tr>";
    }
    ?>
</table>
