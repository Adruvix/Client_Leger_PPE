<h3 class="titre-form">Liste des Utilisateurs</h3>

<table class="tableau">
    <tr>
        <th>ID</th>
        <th>Pseudonyme</th>
        <th>E-mail</th>
        <th>Rôle</th>
        <th>Ville</th>
        <?php if ($peutModifier) { ?><th>Actions</th><?php } ?>
    </tr>

    <?php
    mysqli_data_seek($lesLignes, 0);
    foreach ($lesLignes as $ligne) {
        echo "<tr>";
            echo "<td>".htmlspecialchars($ligne['IdUtilisateur'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($ligne['PseudonymeUtilisateur'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($ligne['MailUtilisateur'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($ligne['RolesUtilisateur'] ?? '')."</td>";
            echo "<td>".htmlspecialchars($ligne['VilleUtilisateur'] ?? '')."</td>";
        if ($peutModifier) {
            echo "<td class='actions'>";
            echo "<a href='index.php?page=13&action=edit&IdUtilisateur=".urlencode($ligne['IdUtilisateur'])."' title='Modifier'>&#9998;</a> ";
            echo "<a href='index.php?page=13&action=sup&IdUtilisateur=".urlencode($ligne['IdUtilisateur'])."' title='Supprimer' onclick=\"return confirm('Confirmer la suppression ?');\">&#128465;</a>";
            echo "</td>";
        }
        echo "</tr>";
    }
    ?>
</table>
