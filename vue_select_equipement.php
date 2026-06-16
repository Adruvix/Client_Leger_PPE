<h3 class="titre-form">Ajouter : Paiement</h3>

<form method="post" class="formulaire">
    <table>
        <tr>
            <td>Date du paiement :</td>
            <td><input type="date" name="DatePayement"></td>
        </tr>
        <tr>
            <td>Date d'encaissement :</td>
            <td><input type="date" name="DateEncaissementPayement"></td>
        </tr>
        <tr>
            <td>Montant (€) :</td>
            <td><input type="number" step="0.01" name="MontantPayement"></td>
        </tr>
        <tr>
            <td>Facture :</td>
            <td><select name="IdFacture"><?php mysqli_data_seek($lesFactures, 0); foreach ($lesFactures as $ligneFk) { echo "<option value='".$ligneFk['IdFacture']."'>".('#'.$ligneFk['IdFacture'])."</option>"; } ?></select></td>
        </tr>
        <tr>
            <td>Type de paiement :</td>
            <td><select name="IdTypePayement"><?php mysqli_data_seek($lesTypesPayement, 0); foreach ($lesTypesPayement as $ligneFk) { echo "<option value='".$ligneFk['IdTypePayement']."'>".('#'.$ligneFk['IdTypePayement'].' - '.$ligneFk['NomTypePayement'])."</option>"; } ?></select></td>
        </tr>
        <tr>
            <td><input type="reset" name="Annuler" value="Annuler"></td>
            <td><input type="submit" name="Valider" value="Valider"></td>
        </tr>
    </table>
</form>
