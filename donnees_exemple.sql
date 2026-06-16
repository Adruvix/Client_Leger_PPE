<?php
/* =====================================================================
 *  Caballio - Couche modele (acces aux donnees)
 *  Toutes les fonctions appelees par les pages et les vues sont ici.
 *  Style procedural + mysqli + requetes preparees.
 * ===================================================================== */

    function connexion()
    {
        $serveur = "localhost";
        $bdd     = "centre_equestre";
        $user    = "root";
        $mdp     = "";
        $uneConnexion = mysqli_connect($serveur, $user, $mdp, $bdd);
        if ($uneConnexion) {
            mysqli_set_charset($uneConnexion, "utf8");
            return $uneConnexion;
        } else {
            echo "<br> Erreur de connexion a la BDD <br>";
            return null;
        }
    }

    function deconnexion($uneConnexion)
    {
        mysqli_close($uneConnexion);
    }

    /* ---------- Authentification ---------- */

    // Compte le nombre d'utilisateurs (sert au premier lancement)
    function compterUtilisateurs()
    {
        $uneConnexion = connexion();
        $res = mysqli_query($uneConnexion, "SELECT COUNT(*) AS nb FROM utilisateur;");
        $ligne = mysqli_fetch_assoc($res);
        deconnexion($uneConnexion);
        return (int) $ligne['nb'];
    }

    // Cree un administrateur par defaut (pseudo: admin / mdp: admin123)
    function creerAdminParDefaut()
    {
        $uneConnexion = connexion();
        $mdp = password_hash("admin123", PASSWORD_DEFAULT);
        $requete = $uneConnexion->prepare(
            "INSERT INTO utilisateur (PseudonymeUtilisateur, MailUtilisateur, MotDePasseUtilisateur, RolesUtilisateur, PrenomUtilisateur, NomUtilisateur)
             VALUES ('admin', 'admin@caballio.fr', ?, 'Admin', 'Admin', 'Caballio')");
        $requete->bind_param("s", $mdp);
        $requete->execute();
        $requete->close();
        deconnexion($uneConnexion);
    }

    // Verifie les identifiants. Retourne la ligne utilisateur ou null.
    function verifierConnexion($identifiant, $motDePasse)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare(
            "SELECT * FROM utilisateur
             WHERE (PseudonymeUtilisateur = ? OR MailUtilisateur = ?)
               AND ActiviteUtilisateur = 1 AND BloqueUtilisateur = 0");
        $requete->bind_param("ss", $identifiant, $identifiant);
        $requete->execute();
        $res = $requete->get_result();
        $utilisateur = $res->fetch_assoc();
        $requete->close();

        if ($utilisateur && password_verify($motDePasse, $utilisateur['MotDePasseUtilisateur'])) {
            // mise a jour de la derniere connexion
            $maj = $uneConnexion->prepare("UPDATE utilisateur SET DerniereConnexionUtilisateur = NOW() WHERE IdUtilisateur = ?");
            $maj->bind_param("i", $utilisateur['IdUtilisateur']);
            $maj->execute();
            $maj->close();
            deconnexion($uneConnexion);
            return $utilisateur;
        }
        deconnexion($uneConnexion);
        return null;
    }

    /* ---------- Centre ---------- */

    function selectAllCentre()
    {
        $uneConnexion = connexion();
        $resultat = mysqli_query($uneConnexion, "SELECT * FROM centre;");
        deconnexion($uneConnexion);
        return $resultat;
    }
    function selectCentreParId($id)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare("SELECT * FROM centre WHERE IdCentre = ?");
        $requete->bind_param("i", $id);
        $requete->execute();
        $res = $requete->get_result();
        $ligne = $res->fetch_assoc();
        $requete->close();
        deconnexion($uneConnexion);
        return $ligne;
    }
    function deleteCentre($id)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare("DELETE FROM centre WHERE IdCentre = ?");
        $requete->bind_param("i", $id);
        $requete->execute();
        $requete->close();
        deconnexion($uneConnexion);
    }
    function insertCentre($tab)
    {
        $uneConnexion = connexion();
        $IdGerant = (isset($tab['IdGerant']) && $tab['IdGerant'] !== '') ? $tab['IdGerant'] : null;
        $requete = $uneConnexion->prepare(
            "INSERT INTO centre (NomCentre, AdresseCentre, CPCentre, VilleCentre, TelCentre, IdGerant) VALUES (?, ?, ?, ?, ?, ?)");
        $requete->bind_param("sssssi", $tab['NomCentre'], $tab['AdresseCentre'], $tab['CPCentre'], $tab['VilleCentre'], $tab['TelCentre'], $IdGerant);
        $requete->execute();
        $requete->close();
        deconnexion($uneConnexion);
    }
    function editCentre($id, $tab)
    {
        $uneConnexion = connexion();
        $IdGerant = (isset($tab['IdGerant']) && $tab['IdGerant'] !== '') ? $tab['IdGerant'] : null;
        $requete = $uneConnexion->prepare(
            "UPDATE centre SET NomCentre = ?, AdresseCentre = ?, CPCentre = ?, VilleCentre = ?, TelCentre = ?, IdGerant = ? WHERE IdCentre = ?");
        $requete->bind_param("sssssii", $tab['NomCentre'], $tab['AdresseCentre'], $tab['CPCentre'], $tab['VilleCentre'], $tab['TelCentre'], $IdGerant, $id);
        $requete->execute();
        $requete->close();
        deconnexion($uneConnexion);
    }

    /* ---------- Pâture ---------- */

    function selectAllPature()
    {
        $uneConnexion = connexion();
        $resultat = mysqli_query($uneConnexion, "SELECT * FROM pature;");
        deconnexion($uneConnexion);
        return $resultat;
    }
    function selectPatureParId($id)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare("SELECT * FROM pature WHERE IdPature = ?");
        $requete->bind_param("i", $id);
        $requete->execute();
        $res = $requete->get_result();
        $ligne = $res->fetch_assoc();
        $requete->close();
        deconnexion($uneConnexion);
        return $ligne;
    }
    function deletePature($id)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare("DELETE FROM pature WHERE IdPature = ?");
        $requete->bind_param("i", $id);
        $requete->execute();
        $requete->close();
        deconnexion($uneConnexion);
    }
    function insertPature($tab)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare(
            "INSERT INTO pature (NomPature, TaillePature, IdCentre) VALUES (?, ?, ?)");
        $requete->bind_param("sdi", $tab['NomPature'], $tab['TaillePature'], $tab['IdCentre']);
        $requete->execute();
        $requete->close();
        deconnexion($uneConnexion);
    }
    function editPature($id, $tab)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare(
            "UPDATE pature SET NomPature = ?, TaillePature = ?, IdCentre = ? WHERE IdPature = ?");
        $requete->bind_param("sdii", $tab['NomPature'], $tab['TaillePature'], $tab['IdCentre'], $id);
        $requete->execute();
        $requete->close();
        deconnexion($uneConnexion);
    }

    /* ---------- Box ---------- */

    function selectAllBox()
    {
        $uneConnexion = connexion();
        $resultat = mysqli_query($uneConnexion, "SELECT * FROM box;");
        deconnexion($uneConnexion);
        return $resultat;
    }
    function selectBoxParId($id)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare("SELECT * FROM box WHERE IdBox = ?");
        $requete->bind_param("i", $id);
        $requete->execute();
        $res = $requete->get_result();
        $ligne = $res->fetch_assoc();
        $requete->close();
        deconnexion($uneConnexion);
        return $ligne;
    }
    function deleteBox($id)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare("DELETE FROM box WHERE IdBox = ?");
        $requete->bind_param("i", $id);
        $requete->execute();
        $requete->close();
        deconnexion($uneConnexion);
    }
    function insertBox($tab)
    {
        $uneConnexion = connexion();
        $IdCheval = (isset($tab['IdCheval']) && $tab['IdCheval'] !== '') ? $tab['IdCheval'] : null;
        // L'insertion peut etre refusee par le trigger trg_verif_cheval_centre_insert
        // (cheval appartenant a un autre centre) : on recupere son message d'erreur.
        $resultat = array("ok" => true, "message" => "Ajout enregistre.");
        try {
            $requete = $uneConnexion->prepare(
                "INSERT INTO box (NumBox, IdCheval, IdTypeLogement, IdCentre) VALUES (?, ?, ?, ?)");
            $requete->bind_param("iiii", $tab['NumBox'], $IdCheval, $tab['IdTypeLogement'], $tab['IdCentre']);
            if (!$requete->execute()) {
                $resultat = array("ok" => false, "message" => $uneConnexion->error);
            }
            $requete->close();
        } catch (mysqli_sql_exception $e) {
            $resultat = array("ok" => false, "message" => $e->getMessage());
        }
        deconnexion($uneConnexion);
        return $resultat;
    }
    function editBox($id, $tab)
    {
        $uneConnexion = connexion();
        $IdCheval = (isset($tab['IdCheval']) && $tab['IdCheval'] !== '') ? $tab['IdCheval'] : null;
        $requete = $uneConnexion->prepare(
            "UPDATE box SET NumBox = ?, IdCheval = ?, IdTypeLogement = ?, IdCentre = ? WHERE IdBox = ?");
        $requete->bind_param("iiiii", $tab['NumBox'], $IdCheval, $tab['IdTypeLogement'], $tab['IdCentre'], $id);
        $requete->execute();
        $requete->close();
        deconnexion($uneConnexion);
    }

    /* ---------- Type de logement ---------- */

    function selectAllTypeLogement()
    {
        $uneConnexion = connexion();
        $resultat = mysqli_query($uneConnexion, "SELECT * FROM type_logement;");
        deconnexion($uneConnexion);
        return $resultat;
    }
    function selectTypeLogementParId($id)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare("SELECT * FROM type_logement WHERE IdTypeLogement = ?");
        $requete->bind_param("i", $id);
        $requete->execute();
        $res = $requete->get_result();
        $ligne = $res->fetch_assoc();
        $requete->close();
        deconnexion($uneConnexion);
        return $ligne;
    }
    function deleteTypeLogement($id)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare("DELETE FROM type_logement WHERE IdTypeLogement = ?");
        $requete->bind_param("i", $id);
        $requete->execute();
        $requete->close();
        deconnexion($uneConnexion);
    }
    function insertTypeLogement($tab)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare(
            "INSERT INTO type_logement (NomTypeLogement, TailleTypeLogement, PrixTypeLogement, IdCentre) VALUES (?, ?, ?, ?)");
        $requete->bind_param("sddi", $tab['NomTypeLogement'], $tab['TailleTypeLogement'], $tab['PrixTypeLogement'], $tab['IdCentre']);
        $requete->execute();
        $requete->close();
        deconnexion($uneConnexion);
    }
    function editTypeLogement($id, $tab)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare(
            "UPDATE type_logement SET NomTypeLogement = ?, TailleTypeLogement = ?, PrixTypeLogement = ?, IdCentre = ? WHERE IdTypeLogement = ?");
        $requete->bind_param("sddii", $tab['NomTypeLogement'], $tab['TailleTypeLogement'], $tab['PrixTypeLogement'], $tab['IdCentre'], $id);
        $requete->execute();
        $requete->close();
        deconnexion($uneConnexion);
    }

    /* ---------- Cheval ---------- */

    function selectAllCheval()
    {
        $uneConnexion = connexion();
        $resultat = mysqli_query($uneConnexion, "SELECT * FROM cheval;");
        deconnexion($uneConnexion);
        return $resultat;
    }
    function selectChevalParId($id)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare("SELECT * FROM cheval WHERE IdCheval = ?");
        $requete->bind_param("i", $id);
        $requete->execute();
        $res = $requete->get_result();
        $ligne = $res->fetch_assoc();
        $requete->close();
        deconnexion($uneConnexion);
        return $ligne;
    }
    function deleteCheval($id)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare("DELETE FROM cheval WHERE IdCheval = ?");
        $requete->bind_param("i", $id);
        $requete->execute();
        $requete->close();
        deconnexion($uneConnexion);
    }
    function insertCheval($tab)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare(
            "INSERT INTO cheval (NomCheval, SexeCheval, RaceCheval, IdCentre, IdClient) VALUES (?, ?, ?, ?, ?)");
        $requete->bind_param("sssii", $tab['NomCheval'], $tab['SexeCheval'], $tab['RaceCheval'], $tab['IdCentre'], $tab['IdClient']);
        $requete->execute();
        $requete->close();
        deconnexion($uneConnexion);
    }
    function editCheval($id, $tab)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare(
            "UPDATE cheval SET NomCheval = ?, SexeCheval = ?, RaceCheval = ?, IdCentre = ?, IdClient = ? WHERE IdCheval = ?");
        $requete->bind_param("sssiii", $tab['NomCheval'], $tab['SexeCheval'], $tab['RaceCheval'], $tab['IdCentre'], $tab['IdClient'], $id);
        $requete->execute();
        $requete->close();
        deconnexion($uneConnexion);
    }

    /* ---------- Équipement ---------- */

    function selectAllEquipement()
    {
        $uneConnexion = connexion();
        $resultat = mysqli_query($uneConnexion, "SELECT * FROM equipement;");
        deconnexion($uneConnexion);
        return $resultat;
    }
    function selectEquipementParId($id)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare("SELECT * FROM equipement WHERE IdEquipement = ?");
        $requete->bind_param("i", $id);
        $requete->execute();
        $res = $requete->get_result();
        $ligne = $res->fetch_assoc();
        $requete->close();
        deconnexion($uneConnexion);
        return $ligne;
    }
    function deleteEquipement($id)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare("DELETE FROM equipement WHERE IdEquipement = ?");
        $requete->bind_param("i", $id);
        $requete->execute();
        $requete->close();
        deconnexion($uneConnexion);
    }
    function insertEquipement($tab)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare(
            "INSERT INTO equipement (LibelleEquipement, IdCentre, IdClient) VALUES (?, ?, ?)");
        $requete->bind_param("sii", $tab['LibelleEquipement'], $tab['IdCentre'], $tab['IdClient']);
        $requete->execute();
        $requete->close();
        deconnexion($uneConnexion);
    }
    function editEquipement($id, $tab)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare(
            "UPDATE equipement SET LibelleEquipement = ?, IdCentre = ?, IdClient = ? WHERE IdEquipement = ?");
        $requete->bind_param("siii", $tab['LibelleEquipement'], $tab['IdCentre'], $tab['IdClient'], $id);
        $requete->execute();
        $requete->close();
        deconnexion($uneConnexion);
    }

    /* ---------- Aliment ---------- */

    function selectAllAliment()
    {
        $uneConnexion = connexion();
        $resultat = mysqli_query($uneConnexion, "SELECT * FROM aliment;");
        deconnexion($uneConnexion);
        return $resultat;
    }
    function selectAlimentParId($id)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare("SELECT * FROM aliment WHERE IdAliment = ?");
        $requete->bind_param("i", $id);
        $requete->execute();
        $res = $requete->get_result();
        $ligne = $res->fetch_assoc();
        $requete->close();
        deconnexion($uneConnexion);
        return $ligne;
    }
    function deleteAliment($id)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare("DELETE FROM aliment WHERE IdAliment = ?");
        $requete->bind_param("i", $id);
        $requete->execute();
        $requete->close();
        deconnexion($uneConnexion);
    }
    function insertAliment($tab)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare(
            "INSERT INTO aliment (NomAliment, IdCentre) VALUES (?, ?)");
        $requete->bind_param("si", $tab['NomAliment'], $tab['IdCentre']);
        $requete->execute();
        $requete->close();
        deconnexion($uneConnexion);
    }
    function editAliment($id, $tab)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare(
            "UPDATE aliment SET NomAliment = ?, IdCentre = ? WHERE IdAliment = ?");
        $requete->bind_param("sii", $tab['NomAliment'], $tab['IdCentre'], $id);
        $requete->execute();
        $requete->close();
        deconnexion($uneConnexion);
    }

    /* ---------- Facture ---------- */

    function selectAllFacture()
    {
        $uneConnexion = connexion();
        $resultat = mysqli_query($uneConnexion, "SELECT * FROM facture;");
        deconnexion($uneConnexion);
        return $resultat;
    }
    function selectFactureParId($id)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare("SELECT * FROM facture WHERE IdFacture = ?");
        $requete->bind_param("i", $id);
        $requete->execute();
        $res = $requete->get_result();
        $ligne = $res->fetch_assoc();
        $requete->close();
        deconnexion($uneConnexion);
        return $ligne;
    }
    function deleteFacture($id)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare("DELETE FROM facture WHERE IdFacture = ?");
        $requete->bind_param("i", $id);
        $requete->execute();
        $requete->close();
        deconnexion($uneConnexion);
    }
    function insertFacture($tab)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare(
            "INSERT INTO facture (DateBail, IdClient, IdCheval, IdTypeLogement, IdCentre) VALUES (?, ?, ?, ?, ?)");
        $requete->bind_param("siiii", $tab['DateBail'], $tab['IdClient'], $tab['IdCheval'], $tab['IdTypeLogement'], $tab['IdCentre']);
        $requete->execute();
        $idFacture = $uneConnexion->insert_id;
        $requete->close();
        // initialise MontantTotal (prix du logement + supplements) via la procedure stockee
        majMontantFacture($uneConnexion, $idFacture);
        deconnexion($uneConnexion);
    }

    function editFacture($id, $tab)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare(
            "UPDATE facture SET DateBail = ?, IdClient = ?, IdCheval = ?, IdTypeLogement = ?, IdCentre = ? WHERE IdFacture = ?");
        $requete->bind_param("siiiii", $tab['DateBail'], $tab['IdClient'], $tab['IdCheval'], $tab['IdTypeLogement'], $tab['IdCentre'], $id);
        $requete->execute();
        $requete->close();
        // recalcul du montant (le type de logement a pu changer)
        majMontantFacture($uneConnexion, $id);
        deconnexion($uneConnexion);
    }

    /* ---------- Supplément ---------- */

    function selectAllSupplement()
    {
        $uneConnexion = connexion();
        $resultat = mysqli_query($uneConnexion, "SELECT * FROM supplement;");
        deconnexion($uneConnexion);
        return $resultat;
    }
    function selectSupplementParId($id)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare("SELECT * FROM supplement WHERE IdSupplement = ?");
        $requete->bind_param("i", $id);
        $requete->execute();
        $res = $requete->get_result();
        $ligne = $res->fetch_assoc();
        $requete->close();
        deconnexion($uneConnexion);
        return $ligne;
    }
    function deleteSupplement($id)
    {
        $uneConnexion = connexion();
        // recuperer la facture liee AVANT suppression (pour le recalcul)
        $req = $uneConnexion->prepare("SELECT IdFacture FROM supplement WHERE IdSupplement = ?");
        $req->bind_param("i", $id);
        $req->execute();
        $res = $req->get_result();
        $ligne = $res->fetch_assoc();
        $req->close();
        // suppression
        $del = $uneConnexion->prepare("DELETE FROM supplement WHERE IdSupplement = ?");
        $del->bind_param("i", $id);
        $del->execute();
        $del->close();
        // recalcul du montant de la facture via la procedure stockee
        if ($ligne) { majMontantFacture($uneConnexion, $ligne['IdFacture']); }
        deconnexion($uneConnexion);
    }
    function insertSupplement($tab)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare(
            "INSERT INTO supplement (NomSupplement, PrixSupplement, IdFacture) VALUES (?, ?, ?)");
        $requete->bind_param("sdi", $tab['NomSupplement'], $tab['PrixSupplement'], $tab['IdFacture']);
        $requete->execute();
        $requete->close();
        // recalcul du montant de la facture via la procedure stockee
        majMontantFacture($uneConnexion, $tab['IdFacture']);
        deconnexion($uneConnexion);
    }

    function editSupplement($id, $tab)
    {
        $uneConnexion = connexion();
        // ancienne facture liee (si le supplement change de facture)
        $req = $uneConnexion->prepare("SELECT IdFacture FROM supplement WHERE IdSupplement = ?");
        $req->bind_param("i", $id);
        $req->execute();
        $res = $req->get_result();
        $ancien = $res->fetch_assoc();
        $req->close();

        $requete = $uneConnexion->prepare(
            "UPDATE supplement SET NomSupplement = ?, PrixSupplement = ?, IdFacture = ? WHERE IdSupplement = ?");
        $requete->bind_param("sdii", $tab['NomSupplement'], $tab['PrixSupplement'], $tab['IdFacture'], $id);
        $requete->execute();
        $requete->close();

        // recalcul des montants (nouvelle et eventuellement ancienne facture)
        majMontantFacture($uneConnexion, $tab['IdFacture']);
        if ($ancien && $ancien['IdFacture'] != $tab['IdFacture']) {
            majMontantFacture($uneConnexion, $ancien['IdFacture']);
        }
        deconnexion($uneConnexion);
    }

    /* ---------- Paiement ---------- */

    function selectAllPayement()
    {
        $uneConnexion = connexion();
        $resultat = mysqli_query($uneConnexion, "SELECT * FROM payement;");
        deconnexion($uneConnexion);
        return $resultat;
    }
    function selectPayementParId($id)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare("SELECT * FROM payement WHERE IdPayement = ?");
        $requete->bind_param("i", $id);
        $requete->execute();
        $res = $requete->get_result();
        $ligne = $res->fetch_assoc();
        $requete->close();
        deconnexion($uneConnexion);
        return $ligne;
    }
    function deletePayement($id)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare("DELETE FROM payement WHERE IdPayement = ?");
        $requete->bind_param("i", $id);
        $requete->execute();
        $requete->close();
        deconnexion($uneConnexion);
    }
    function insertPayement($tab)
    {
        $uneConnexion = connexion();
        $DateEncaissementPayement = (isset($tab['DateEncaissementPayement']) && $tab['DateEncaissementPayement'] !== '') ? $tab['DateEncaissementPayement'] : null;
        $requete = $uneConnexion->prepare(
            "INSERT INTO payement (DatePayement, DateEncaissementPayement, MontantPayement, IdFacture, IdTypePayement) VALUES (?, ?, ?, ?, ?)");
        $requete->bind_param("ssdii", $tab['DatePayement'], $DateEncaissementPayement, $tab['MontantPayement'], $tab['IdFacture'], $tab['IdTypePayement']);
        $requete->execute();
        $requete->close();
        deconnexion($uneConnexion);
    }
    function editPayement($id, $tab)
    {
        $uneConnexion = connexion();
        $DateEncaissementPayement = (isset($tab['DateEncaissementPayement']) && $tab['DateEncaissementPayement'] !== '') ? $tab['DateEncaissementPayement'] : null;
        $requete = $uneConnexion->prepare(
            "UPDATE payement SET DatePayement = ?, DateEncaissementPayement = ?, MontantPayement = ?, IdFacture = ?, IdTypePayement = ? WHERE IdPayement = ?");
        $requete->bind_param("ssdiii", $tab['DatePayement'], $DateEncaissementPayement, $tab['MontantPayement'], $tab['IdFacture'], $tab['IdTypePayement'], $id);
        $requete->execute();
        $requete->close();
        deconnexion($uneConnexion);
    }

    /* ---------- Type de paiement ---------- */

    function selectAllTypePayement()
    {
        $uneConnexion = connexion();
        $resultat = mysqli_query($uneConnexion, "SELECT * FROM type_payement;");
        deconnexion($uneConnexion);
        return $resultat;
    }
    function selectTypePayementParId($id)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare("SELECT * FROM type_payement WHERE IdTypePayement = ?");
        $requete->bind_param("i", $id);
        $requete->execute();
        $res = $requete->get_result();
        $ligne = $res->fetch_assoc();
        $requete->close();
        deconnexion($uneConnexion);
        return $ligne;
    }
    function deleteTypePayement($id)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare("DELETE FROM type_payement WHERE IdTypePayement = ?");
        $requete->bind_param("i", $id);
        $requete->execute();
        $requete->close();
        deconnexion($uneConnexion);
    }
    function insertTypePayement($tab)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare(
            "INSERT INTO type_payement (NomTypePayement) VALUES (?)");
        $requete->bind_param("s", $tab['NomTypePayement']);
        $requete->execute();
        $requete->close();
        deconnexion($uneConnexion);
    }
    function editTypePayement($id, $tab)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare(
            "UPDATE type_payement SET NomTypePayement = ? WHERE IdTypePayement = ?");
        $requete->bind_param("si", $tab['NomTypePayement'], $id);
        $requete->execute();
        $requete->close();
        deconnexion($uneConnexion);
    }

    /* ---------- Utilisateur ---------- */

    function selectAllUtilisateur()
    {
        $uneConnexion = connexion();
        $resultat = mysqli_query($uneConnexion, "SELECT * FROM utilisateur;");
        deconnexion($uneConnexion);
        return $resultat;
    }
    function selectUtilisateurParId($id)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare("SELECT * FROM utilisateur WHERE IdUtilisateur = ?");
        $requete->bind_param("i", $id);
        $requete->execute();
        $res = $requete->get_result();
        $ligne = $res->fetch_assoc();
        $requete->close();
        deconnexion($uneConnexion);
        return $ligne;
    }
    function deleteUtilisateur($id)
    {
        $uneConnexion = connexion();
        $requete = $uneConnexion->prepare("DELETE FROM utilisateur WHERE IdUtilisateur = ?");
        $requete->bind_param("i", $id);
        $requete->execute();
        $requete->close();
        deconnexion($uneConnexion);
    }
    function insertUtilisateur($tab)
    {
        $uneConnexion = connexion();
        $mdp = password_hash($tab['MotDePasseUtilisateur'], PASSWORD_DEFAULT);
        $requete = $uneConnexion->prepare(
            "INSERT INTO utilisateur
             (PseudonymeUtilisateur, MailUtilisateur, MotDePasseUtilisateur, RolesUtilisateur,
              PrenomUtilisateur, NomUtilisateur, SexeUtilisateur, AdresseUtilisateur,
              CodePostalUtilisateur, VilleUtilisateur)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $requete->bind_param("ssssssssss",
            $tab['PseudonymeUtilisateur'], $tab['MailUtilisateur'], $mdp, $tab['RolesUtilisateur'],
            $tab['PrenomUtilisateur'], $tab['NomUtilisateur'], $tab['SexeUtilisateur'],
            $tab['AdresseUtilisateur'], $tab['CodePostalUtilisateur'], $tab['VilleUtilisateur']);
        $requete->execute();
        $requete->close();
        deconnexion($uneConnexion);
    }

    function editUtilisateur($id, $tab)
    {
        $uneConnexion = connexion();
        // Le mot de passe n'est mis a jour que s'il a ete saisi
        if (isset($tab['MotDePasseUtilisateur']) && $tab['MotDePasseUtilisateur'] !== '') {
            $mdp = password_hash($tab['MotDePasseUtilisateur'], PASSWORD_DEFAULT);
            $requete = $uneConnexion->prepare(
                "UPDATE utilisateur SET PseudonymeUtilisateur = ?, MailUtilisateur = ?, MotDePasseUtilisateur = ?,
                    RolesUtilisateur = ?, PrenomUtilisateur = ?, NomUtilisateur = ?, SexeUtilisateur = ?,
                    AdresseUtilisateur = ?, CodePostalUtilisateur = ?, VilleUtilisateur = ?
                 WHERE IdUtilisateur = ?");
            $requete->bind_param("ssssssssssi",
                $tab['PseudonymeUtilisateur'], $tab['MailUtilisateur'], $mdp, $tab['RolesUtilisateur'],
                $tab['PrenomUtilisateur'], $tab['NomUtilisateur'], $tab['SexeUtilisateur'],
                $tab['AdresseUtilisateur'], $tab['CodePostalUtilisateur'], $tab['VilleUtilisateur'], $id);
        } else {
            $requete = $uneConnexion->prepare(
                "UPDATE utilisateur SET PseudonymeUtilisateur = ?, MailUtilisateur = ?,
                    RolesUtilisateur = ?, PrenomUtilisateur = ?, NomUtilisateur = ?, SexeUtilisateur = ?,
                    AdresseUtilisateur = ?, CodePostalUtilisateur = ?, VilleUtilisateur = ?
                 WHERE IdUtilisateur = ?");
            $requete->bind_param("sssssssssi",
                $tab['PseudonymeUtilisateur'], $tab['MailUtilisateur'], $tab['RolesUtilisateur'],
                $tab['PrenomUtilisateur'], $tab['NomUtilisateur'], $tab['SexeUtilisateur'],
                $tab['AdresseUtilisateur'], $tab['CodePostalUtilisateur'], $tab['VilleUtilisateur'], $id);
        }
        $requete->execute();
        $requete->close();
        deconnexion($uneConnexion);
    }

    /* ---------- Vues, fonction et procedure de la base ---------- */

    // Vue v_facture_resume : factures avec total paye et restant a payer
    function selectResumeFactures()
    {
        $uneConnexion = connexion();
        $resultat = mysqli_query($uneConnexion, "SELECT * FROM v_facture_resume;");
        deconnexion($uneConnexion);
        return $resultat;
    }

    // Vue v_total_restant_global : total restant a payer, tous clients confondus
    function selectTotalRestantGlobal()
    {
        $uneConnexion = connexion();
        $res = mysqli_query($uneConnexion, "SELECT RestantTotalClients FROM v_total_restant_global;");
        $ligne = mysqli_fetch_assoc($res);
        deconnexion($uneConnexion);
        return $ligne ? $ligne['RestantTotalClients'] : 0;
    }

    // Vue v_box_stats_centre : nombre de box total et vides par centre
    function selectStatsBox()
    {
        $uneConnexion = connexion();
        $resultat = mysqli_query($uneConnexion,
            "SELECT s.IdCentre, c.NomCentre, s.NbBoxTotal, s.NbBoxVides
             FROM v_box_stats_centre s
             JOIN centre c ON c.IdCentre = s.IdCentre;");
        deconnexion($uneConnexion);
        return $resultat;
    }

    // Procedure sp_maj_montant_facture : recalcule MontantTotal (logement + supplements).
    // Recoit une connexion deja ouverte pour etre appelee depuis insert/delete supplement.
    function majMontantFacture($uneConnexion, $idFacture)
    {
        $stmt = $uneConnexion->prepare("CALL sp_maj_montant_facture(?)");
        $stmt->bind_param("i", $idFacture);
        $stmt->execute();
        $stmt->close();
    }

    /* ---------- Clients (utilises pour les listes deroulantes) ---------- */
    function selectAllClients()
    {
        $uneConnexion = connexion();
        $resultat = mysqli_query($uneConnexion, "SELECT * FROM client;");
        deconnexion($uneConnexion);
        return $resultat;
    }

?>
