<h3 class="titre-form">Ajouter : Type de logement</h3>

<form method="post" class="formulaire">
    <table>
        <tr>
            <td>Libellé :</td>
            <td><input type="text" name="NomTypeLogement"></td>
        </tr>
        <tr>
            <td>Taille (m²) :</td>
            <td><input type="number" step="0.01" name="TailleTypeLogement"></td>
        </tr>
        <tr>
            <td>Prix (€) :</td>
            <td><input type="number" step="0.01" name="PrixTypeLogement"></td>
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
