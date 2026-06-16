<h3 class="titre-form">Liste des Aliments</h3>

<table class="tableau">
    <tr>
        <th>ID</th>
        <th>Nom de l'aliment</th>
        <th>Centre</th>
        <?php if ($peutModifier) { ?><th>Actions</th><?php } ?>
    </tr>

    <?php
    mysqli_data_seek($lesLignes, 0);
    foreach ($lesLignes as $ligne) {
        echo "<tr>";
            echo "<td>".htmlspecialchars($ligne['IdAliment'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($ligne['NomAliment'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($ligne['IdCentre'] ?? '')."</td>";
        if ($peutModifier) {
            echo "<td class='actions'>";
            echo "<a href='index.php?page=8&action=edit&IdAliment=".urlencode($ligne['IdAliment'])."' title='Modifier'>&#9998;</a> ";
            echo "<a href='index.php?page=8&action=sup&IdAliment=".urlencode($ligne['IdAliment'])."' title='Supprimer' onclick=\"return confirm('Confirmer la suppression ?');\">&#128465;</a>";
            echo "</td>";
        }
        echo "</tr>";
    }
    ?>
</table>
