<h3 class="titre-form">Ajouter : Cheval</h3>

<form method="post" class="formulaire">
    <table>
        <tr>
            <td>Nom du cheval :</td>
            <td><input type="text" name="NomCheval"></td>
        </tr>
        <tr>
            <td>Sexe :</td>
            <td><select name="SexeCheval"><option value="M">M</option><option value="F">F</option></select></td>
        </tr>
        <tr>
            <td>Race :</td>
            <td><input type="text" name="RaceCheval"></td>
        </tr>
        <tr>
            <td>Centre :</td>
            <td><select name="IdCentre"><?php mysqli_data_seek($lesCentres, 0); foreach ($lesCentres as $ligneFk) { echo "<option value='".$ligneFk['IdCentre']."'>".('#'.$ligneFk['IdCentre'].' - '.$ligneFk['NomCentre'])."</option>"; } ?></select></td>
        </tr>
        <tr>
            <td>Propriétaire (client) :</td>
            <td><select name="IdClient"><?php mysqli_data_seek($lesClients, 0); foreach ($lesClients as $ligneFk) { echo "<option value='".$ligneFk['IdClient']."'>".('#'.$ligneFk['IdClient'].' - '.$ligneFk['NomClient'])."</option>"; } ?></select></td>
        </tr>
        <tr>
            <td><input type="reset" name="Annuler" value="Annuler"></td>
            <td><input type="submit" name="Valider" value="Valider"></td>
        </tr>
    </table>
</form>
