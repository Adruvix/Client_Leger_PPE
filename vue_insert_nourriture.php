DROP DATABASE IF EXISTS centre_equestre;
CREATE DATABASE centre_equestre;
USE centre_equestre;

CREATE TABLE utilisateur
(
    IdUtilisateur INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    PseudonymeUtilisateur VARCHAR(80) NOT NULL UNIQUE,
    MailUtilisateur VARCHAR(120) NOT NULL UNIQUE,
    MotDePasseUtilisateur VARCHAR(120) NOT NULL,
    ActiviteUtilisateur BOOLEAN NOT NULL DEFAULT 1,
    DerniereConnexionUtilisateur DATETIME NULL,
    BloqueUtilisateur BOOLEAN NOT NULL DEFAULT 0,
    RolesUtilisateur ENUM('Admin', 'Gerant', 'Client') NOT NULL,
    ExpireUtilisateur BOOLEAN NOT NULL DEFAULT 0,
    PrenomUtilisateur VARCHAR(50) NOT NULL,
    NomUtilisateur VARCHAR(50) NOT NULL,
    SexeUtilisateur ENUM('M', 'F', 'Autre') NULL,
    AdresseUtilisateur VARCHAR(255) NULL,
    CodePostalUtilisateur VARCHAR(10) NULL,
    VilleUtilisateur VARCHAR(255) NULL,
    DateCreationUtilisateur DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE centre
(
    IdCentre INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    NomCentre VARCHAR(80) NOT NULL,
    AdresseCentre VARCHAR(255) NOT NULL,
    CPCentre VARCHAR(10) NULL,
    VilleCentre VARCHAR(255) NULL,
    TelCentre VARCHAR(20) NULL,
    DateAjoutCentre DATE NOT NULL DEFAULT CURRENT_DATE,
    IdGerant INT UNSIGNED NULL,
    CONSTRAINT fk_centre_gerant
        FOREIGN KEY (IdGerant)
        REFERENCES utilisateur(IdUtilisateur)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE client
(
    IdClient INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    NomClient VARCHAR(50) NOT NULL,
    PrenomClient VARCHAR(50) NOT NULL,
    AdresseClient VARCHAR(255) NOT NULL,
    CodePostalClient VARCHAR(10) NOT NULL,
    VilleClient VARCHAR(255) NULL,
    TelClient VARCHAR(20) NULL,
    DateAjoutClient DATE NOT NULL DEFAULT CURRENT_DATE
) ENGINE=InnoDB;

CREATE TABLE pature
(
    IdPature INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    NomPature VARCHAR(50) NOT NULL,
    TaillePature DECIMAL(10,2) NOT NULL,
    DateAjoutPature DATE NOT NULL DEFAULT CURRENT_DATE,
    IdCentre INT UNSIGNED NOT NULL,
    CONSTRAINT fk_pature_centre
        FOREIGN KEY (IdCentre)
        REFERENCES centre(IdCentre)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE type_logement
(
    IdTypeLogement INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    NomTypeLogement VARCHAR(50) NOT NULL,
    TailleTypeLogement DECIMAL(10,2) NOT NULL,
    PrixTypeLogement DECIMAL(10,2) NOT NULL,
    DateAjoutTypeLogement DATE NOT NULL DEFAULT CURRENT_DATE,
    IdCentre INT UNSIGNED NOT NULL,
    CONSTRAINT fk_type_logement_centre
        FOREIGN KEY (IdCentre)
        REFERENCES centre(IdCentre)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE cheval
(
    IdCheval INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    NomCheval VARCHAR(50) NOT NULL,
    SexeCheval ENUM('M', 'F') NOT NULL,
    RaceCheval VARCHAR(255) NOT NULL,
    DateAjoutCheval DATE NOT NULL DEFAULT CURRENT_DATE,
    IdCentre INT UNSIGNED NOT NULL,
    IdClient INT UNSIGNED NOT NULL,
    CONSTRAINT fk_cheval_centre
        FOREIGN KEY (IdCentre)
        REFERENCES centre(IdCentre)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    CONSTRAINT fk_cheval_client
        FOREIGN KEY (IdClient)
        REFERENCES client(IdClient)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE box
(
    IdBox INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    NumBox INT NOT NULL,
    DateAjoutBox DATE NOT NULL DEFAULT CURRENT_DATE,
    IdCheval INT UNSIGNED NULL,
    IdTypeLogement INT UNSIGNED NOT NULL,
    IdCentre INT UNSIGNED NOT NULL,

    CONSTRAINT uq_box_numero_par_centre UNIQUE (IdCentre, NumBox),
    CONSTRAINT uq_box_par_cheval UNIQUE (IdCheval),

    CONSTRAINT fk_box_cheval
        FOREIGN KEY (IdCheval)
        REFERENCES cheval(IdCheval)
        ON UPDATE CASCADE
        ON DELETE SET NULL,

    CONSTRAINT fk_box_type_logement
        FOREIGN KEY (IdTypeLogement)
        REFERENCES type_logement(IdTypeLogement)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT fk_box_centre
        FOREIGN KEY (IdCentre)
        REFERENCES centre(IdCentre)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE equipement
(
    IdEquipement INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    LibelleEquipement VARCHAR(50) NOT NULL,
    DateAjoutEquipement DATE NOT NULL DEFAULT CURRENT_DATE,
    IdCentre INT UNSIGNED NOT NULL,
    IdClient INT UNSIGNED NOT NULL,
    CONSTRAINT fk_equipement_centre
        FOREIGN KEY (IdCentre)
        REFERENCES centre(IdCentre)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    CONSTRAINT fk_equipement_client
        FOREIGN KEY (IdClient)
        REFERENCES client(IdClient)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE aliment
(
    IdAliment INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    NomAliment VARCHAR(50) NOT NULL,
    IdCentre INT UNSIGNED NOT NULL,
    CONSTRAINT fk_aliment_centre
        FOREIGN KEY (IdCentre)
        REFERENCES centre(IdCentre)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE facture
(
    IdFacture INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    DateBail DATE NOT NULL,
    MontantTotal DECIMAL(10,2) NOT NULL DEFAULT 0,
    DateAjoutFacture DATE NOT NULL DEFAULT CURRENT_DATE,
    IdClient INT UNSIGNED NOT NULL,
    IdCheval INT UNSIGNED NOT NULL,
    IdTypeLogement INT UNSIGNED NOT NULL,
    IdCentre INT UNSIGNED NOT NULL,

    CONSTRAINT fk_facture_client
        FOREIGN KEY (IdClient)
        REFERENCES client(IdClient)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT fk_facture_cheval
        FOREIGN KEY (IdCheval)
        REFERENCES cheval(IdCheval)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT fk_facture_type_logement
        FOREIGN KEY (IdTypeLogement)
        REFERENCES type_logement(IdTypeLogement)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT fk_facture_centre
        FOREIGN KEY (IdCentre)
        REFERENCES centre(IdCentre)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE supplement
(
    IdSupplement INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    NomSupplement VARCHAR(255) NOT NULL,
    PrixSupplement DECIMAL(10,2) NOT NULL,
    IdFacture INT UNSIGNED NOT NULL,
    CONSTRAINT fk_supplement_facture
        FOREIGN KEY (IdFacture)
        REFERENCES facture(IdFacture)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE type_payement
(
    IdTypePayement INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    NomTypePayement VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE payement
(
    IdPayement INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    DatePayement DATE NOT NULL,
    DateEncaissementPayement DATE NULL,
    MontantPayement DECIMAL(10,2) NOT NULL,
    IdFacture INT UNSIGNED NOT NULL,
    IdTypePayement INT UNSIGNED NOT NULL,

    CONSTRAINT fk_payement_facture
        FOREIGN KEY (IdFacture)
        REFERENCES facture(IdFacture)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT fk_payement_type
        FOREIGN KEY (IdTypePayement)
        REFERENCES type_payement(IdTypePayement)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE OR REPLACE VIEW v_facture_resume AS
SELECT
    f.IdFacture,
    f.IdClient,
    f.IdCheval,
    f.IdTypeLogement,
    f.IdCentre,
    f.DateBail,
    f.DateAjoutFacture,
    f.MontantTotal,
    COALESCE(SUM(p.MontantPayement), 0) AS PaiementTotal,
    (f.MontantTotal - COALESCE(SUM(p.MontantPayement), 0)) AS PaiementRestant
FROM facture f
LEFT JOIN payement p ON p.IdFacture = f.IdFacture
GROUP BY
    f.IdFacture,
    f.IdClient,
    f.IdCheval,
    f.IdTypeLogement,
    f.IdCentre,
    f.DateBail,
    f.DateAjoutFacture,
    f.MontantTotal;

CREATE OR REPLACE VIEW v_total_restant_global AS
SELECT
    COALESCE(SUM(PaiementRestant), 0) AS RestantTotalClients
FROM v_facture_resume;

CREATE OR REPLACE VIEW v_box_stats_centre AS
SELECT
    b.IdCentre,
    COUNT(*) AS NbBoxTotal,
    SUM(CASE WHEN b.IdCheval IS NULL THEN 1 ELSE 0 END) AS NbBoxVides
FROM box b
GROUP BY b.IdCentre;


DELIMITER $$

CREATE TRIGGER trg_verif_cheval_centre_insert
BEFORE INSERT ON box
FOR EACH ROW
BEGIN
    DECLARE CentreCheval INT UNSIGNED;

    IF NEW.IdCheval IS NOT NULL THEN
        SELECT IdCentre
        INTO CentreCheval
        FROM cheval
        WHERE IdCheval = NEW.IdCheval;

        IF CentreCheval IS NULL THEN
            SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'Erreur : le cheval est inexistant.';
        END IF;

        IF CentreCheval <> NEW.IdCentre THEN
            SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'Erreur : le cheval appartient à un autre centre.';
        END IF;
    END IF;
END $$

DELIMITER ;

DELIMITER $$

CREATE FUNCTION fn_total_supplements(idFacture INT)
RETURNS DECIMAL(10,2)
DETERMINISTIC
BEGIN
    DECLARE total DECIMAL(10,2);

    SELECT COALESCE(SUM(PrixSupplement), 0)
    INTO total
    FROM supplement
    WHERE IdFacture = idFacture;

    RETURN total;
END $$

DELIMITER ;


DELIMITER $$

CREATE PROCEDURE sp_maj_montant_facture(IN idFacture INT)
BEGIN
    DECLARE prixLogement DECIMAL(10,2);
    DECLARE totalSupp DECIMAL(10,2);

    -- récupérer le prix du logement
    SELECT t.PrixTypeLogement
    INTO prixLogement
    FROM facture f
    JOIN type_logement t ON f.IdTypeLogement = t.IdTypeLogement
    WHERE f.IdFacture = idFacture;

    -- récupérer le total des suppléments via la fonction
    SET totalSupp = fn_total_supplements(idFacture);

    -- mise à jour de la facture
    UPDATE facture
    SET MontantTotal = prixLogement + totalSupp
    WHERE IdFacture = idFacture;
END $$

DELIMITER ;