<h3 class="titre-form">Liste des Chevaux</h3>

<table class="tableau">
    <tr>
        <th>ID</th>
        <th>Nom du cheval</th>
        <th>Sexe</th>
        <th>Race</th>
        <th>Centre</th>
        <th>Propriétaire (client)</th>
        <th>Date d'ajout</th>
        <?php if ($peutModifier) { ?><th>Actions</th><?php } ?>
    </tr>

    <?php
    mysqli_data_seek($lesLignes, 0);
    foreach ($lesLignes as $ligne) {
        echo "<tr>";
            echo "<td>".htmlspecialchars($ligne['IdCheval'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($ligne['NomCheval'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($ligne['SexeCheval'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($ligne['RaceCheval'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($ligne['IdCentre'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($ligne['IdClient'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($ligne['DateAjoutCheval'] ?? '')."</td>";
        if ($peutModifier) {
            echo "<td class='actions'>";
            echo "<a href='index.php?page=6&action=edit&IdCheval=".urlencode($ligne['IdCheval'])."' title='Modifier'>&#9998;</a> ";
            echo "<a href='index.php?page=6&action=sup&IdCheval=".urlencode($ligne['IdCheval'])."' title='Supprimer' onclick=\"return confirm('Confirmer la suppression ?');\">&#128465;</a>";
            echo "</td>";
        }
        echo "</tr>";
    }
    ?>
</table>
