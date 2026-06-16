<h3 class="titre-form">Ajouter : Utilisateur</h3>

<form method="post" class="formulaire">
    <table>
        <tr>
            <td>Pseudonyme :</td>
            <td><input type="text" name="PseudonymeUtilisateur"></td>
        </tr>
        <tr>
            <td>E-mail :</td>
            <td><input type="text" name="MailUtilisateur"></td>
        </tr>
        <tr>
            <td>Mot de passe :</td>
            <td><input type="password" name="MotDePasseUtilisateur"></td>
        </tr>
        <tr>
            <td>Rôle :</td>
            <td><select name="RolesUtilisateur"><option value="Admin">Admin</option><option value="Gerant">Gerant</option><option value="Client">Client</option></select></td>
        </tr>
        <tr>
            <td>Prénom :</td>
            <td><input type="text" name="PrenomUtilisateur"></td>
        </tr>
        <tr>
            <td>Nom :</td>
            <td><input type="text" name="NomUtilisateur"></td>
        </tr>
        <tr>
            <td>Sexe :</td>
            <td><select name="SexeUtilisateur"><option value="M">M</option><option value="F">F</option><option value="Autre">Autre</option></select></td>
        </tr>
        <tr>
            <td>Adresse :</td>
            <td><input type="text" name="AdresseUtilisateur"></td>
        </tr>
        <tr>
            <td>Code postal :</td>
            <td><input type="text" name="CodePostalUtilisateur"></td>
        </tr>
        <tr>
            <td>Ville :</td>
            <td><input type="text" name="VilleUtilisateur"></td>
        </tr>
        <tr>
            <td><input type="reset" name="Annuler" value="Annuler"></td>
            <td><input type="submit" name="Valider" value="Valider"></td>
        </tr>
    </table>
</form>
