-- =====================================================================
--  Donnees d'exemple (OPTIONNEL)
--  A executer APRES Caballio_2.0.sql si vous voulez des donnees de test.
--  Le compte administrateur (admin / admin123) est cree automatiquement
--  au premier lancement par la page login.php, il n'est donc pas ici.
-- =====================================================================
USE centre_equestre;

INSERT INTO client (NomClient, PrenomClient, AdresseClient, CodePostalClient, VilleClient, TelClient) VALUES
('Durand', 'Marie',  '12 rue des Ecuries', '31000', 'Toulouse', '0561000001'),
('Martin', 'Lucas',  '5 chemin du Pre',    '31200', 'Toulouse', '0561000002');

INSERT INTO centre (NomCentre, AdresseCentre, CPCentre, VilleCentre, TelCentre) VALUES
('Centre du Soleil', '40 route de Blagnac', '31700', 'Blagnac', '0561111111');

INSERT INTO type_payement (NomTypePayement) VALUES
('Especes'), ('Carte bancaire'), ('Virement'), ('Cheque');
