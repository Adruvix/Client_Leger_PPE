<h3 class="titre-form">Ajouter : Facture</h3>

<form method="post" class="formulaire">
    <table>
        <tr>
            <td>Date du bail :</td>
            <td><input type="date" name="DateBail"></td>
        </tr>
        <tr>
            <td>Client :</td>
            <td><select name="IdClient"><?php mysqli_data_seek($lesClients, 0); foreach ($lesClients as $ligneFk) { echo "<option value='".$ligneFk['IdClient']."'>".('#'.$ligneFk['IdClient'].' - '.$ligneFk['NomClient'])."</option>"; } ?></select></td>
        </tr>
        <tr>
            <td>Cheval :</td>
            <td><select name="IdCheval"><?php mysqli_data_seek($lesChevaux, 0); foreach ($lesChevaux as $ligneFk) { echo "<option value='".$ligneFk['IdCheval']."'>".('#'.$ligneFk['IdCheval'].' - '.$ligneFk['NomCheval'])."</option>"; } ?></select></td>
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
