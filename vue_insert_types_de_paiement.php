<h3 class="titre-form">Liste des Types de paiement</h3>

<table class="tableau">
    <tr>
        <th>ID</th>
        <th>Libellé</th>
        <?php if ($peutModifier) { ?><th>Actions</th><?php } ?>
    </tr>

    <?php
    mysqli_data_seek($lesLignes, 0);
    foreach ($lesLignes as $ligne) {
        echo "<tr>";
            echo "<td>".htmlspecialchars($ligne['IdTypePayement'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($ligne['NomTypePayement'] ?? '')."</td>";
        if ($peutModifier) {
            echo "<td class='actions'>";
            echo "<a href='index.php?page=12&action=edit&IdTypePayement=".urlencode($ligne['IdTypePayement'])."' title='Modifier'>&#9998;</a> ";
            echo "<a href='index.php?page=12&action=sup&IdTypePayement=".urlencode($ligne['IdTypePayement'])."' title='Supprimer' onclick=\"return confirm('Confirmer la suppression ?');\">&#128465;</a>";
            echo "</td>";
        }
        echo "</tr>";
    }
    ?>
</table>
