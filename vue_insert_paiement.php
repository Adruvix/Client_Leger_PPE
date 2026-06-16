<h3 class="titre-form">Ajouter : Box</h3>

<form method="post" class="formulaire">
    <table>
        <tr>
            <td>Numéro du box :</td>
            <td><input type="number" name="NumBox"></td>
        </tr>
        <tr>
            <td>Cheval (occupant) :</td>
            <td><select name="IdCheval"><option value="">-- Aucun --</option><?php mysqli_data_seek($lesChevaux, 0); foreach ($lesChevaux as $ligneFk) { echo "<option value='".$ligneFk['IdCheval']."'>".('#'.$ligneFk['IdCheval'].' - '.$ligneFk['NomCheval'])."</option>"; } ?></select></td>
        </tr>
        <tr>
            <td>Type de logement :</td>
            <td><select name="IdTypeLogement"><?php mysqli_data_seek($lesTypesLogement, 0); foreach ($lesTypesLogement as $ligneFk) { echo "<option value='".$ligneFk['IdTypeLogement']."'>".('#'.$ligneFk['IdTypeLogement'].' - '.$ligneFk['NomTypeLogement'])."</option>"; } ?></select></td>
        </tr>
        <tr>
            <td>Centre :</td>
            <td><select name="IdCentre"><?php mysqli_data_seek($lesCentres, 0); foreach ($lesCentres as $ligneFk) { echo "<option value='".$ligneFk['IdCentre']."'>".('#'.$ligneFk['IdCentre'].' - '.$ligneFk['NomCentre'])."</option>"; } ?></select></td>
        </tr>
        <tr>
            <td><input type="reset" name="Annuler" value="Annuler"></td>
            <td><input type="submit" name="Valider" value="Valider"></td>
        </tr>
    </table>
</form>
