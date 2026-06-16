<h3 class="titre-form">Ajouter : Supplément</h3>

<form method="post" class="formulaire">
    <table>
        <tr>
            <td>Libellé :</td>
            <td><input type="text" name="NomSupplement"></td>
        </tr>
        <tr>
            <td>Prix (€) :</td>
            <td><input type="number" step="0.01" name="PrixSupplement"></td>
        </tr>
        <tr>
            <td>Facture :</td>
            <td><select name="IdFacture"><?php mysqli_data_seek($lesFactures, 0); foreach ($lesFactures as $ligneFk) { echo "<option value='".$ligneFk['IdFacture']."'>".('#'.$ligneFk['IdFacture'])."</option>"; } ?></select></td>
        </tr>
        <tr>
            <td><input type="reset" name="Annuler" value="Annuler"></td>
            <td><input type="submit" name="Valider" value="Valider"></td>
        </tr>
    </table>
</form>
