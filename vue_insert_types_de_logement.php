<h3 class="titre-form">Liste des Types de logement</h3>

<table class="tableau">
    <tr>
        <th>ID</th>
        <th>Libellé</th>
        <th>Taille (m²)</th>
        <th>Prix (€)</th>
        <th>Centre</th>
        <th>Date d'ajout</th>
        <?php if ($peutModifier) { ?><th>Actions</th><?php } ?>
    </tr>

    <?php
    mysqli_data_seek($lesLignes, 0);
    foreach ($lesLignes as $ligne) {
        echo "<tr>";
            echo "<td>".htmlspecialchars($ligne['IdTypeLogement'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($ligne['NomTypeLogement'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($ligne['TailleTypeLogement'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($ligne['PrixTypeLogement'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($ligne['IdCentre'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($ligne['DateAjoutTypeLogement'] ?? '')."</td>";
        if ($peutModifier) {
            echo "<td class='actions'>";
            echo "<a href='index.php?page=5&action=edit&IdTypeLogement=".urlencode($ligne['IdTypeLogement'])."' title='Modifier'>&#9998;</a> ";
            echo "<a href='index.php?page=5&action=sup&IdTypeLogement=".urlencode($ligne['IdTypeLogement'])."' title='Supprimer' onclick=\"return confirm('Confirmer la suppression ?');\">&#128465;</a>";
            echo "</td>";
        }
        echo "</tr>";
    }
    ?>
</table>
