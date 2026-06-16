<h3 class="titre-form">Liste des Pâtures</h3>

<table class="tableau">
    <tr>
        <th>ID</th>
        <th>Nom de la pâture</th>
        <th>Taille (m²)</th>
        <th>Centre</th>
        <th>Date d'ajout</th>
        <?php if ($peutModifier) { ?><th>Actions</th><?php } ?>
    </tr>

    <?php
    mysqli_data_seek($lesLignes, 0);
    foreach ($lesLignes as $ligne) {
        echo "<tr>";
            echo "<td>".htmlspecialchars($ligne['IdPature'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($ligne['NomPature'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($ligne['TaillePature'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($ligne['IdCentre'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($ligne['DateAjoutPature'] ?? '')."</td>";
        if ($peutModifier) {
            echo "<td class='actions'>";
            echo "<a href='index.php?page=3&action=edit&IdPature=".urlencode($ligne['IdPature'])."' title='Modifier'>&#9998;</a> ";
            echo "<a href='index.php?page=3&action=sup&IdPature=".urlencode($ligne['IdPature'])."' title='Supprimer' onclick=\"return confirm('Confirmer la suppression ?');\">&#128465;</a>";
            echo "</td>";
        }
        echo "</tr>";
    }
    ?>
</table>
