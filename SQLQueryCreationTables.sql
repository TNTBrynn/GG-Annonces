DROP DATABASE IF EXISTS pjf_GLMS;
CREATE DATABASE IF NOT EXISTS pjf_GLMS;
USE pjf_GLMS;
DROP TABLE IF EXISTS 'utilisateurs';
CREATE TABLE 'utilisateurs'(
    'NoUtilisateur' INT NOT NULL AUTO_INCREMENT CHECK (NoUtilisateur > 0 && NoUtilisateur < 1000),
    'Courriel' varchar(50) DEFAULT NULL,
    'MotDePasse' varchar(15) DEFAULT NULL,
    'Creation' DATE current_date,
    'NbConnexions' int DEFAULT 0 CHECK (NbConnexions >= 0 && NbConnexions < 1000),
    'Statut' int DEFAULT 0, --le statut est confirmé avec un mail
    'NoEmpl' int CHECK (NoEmpl > 0 || NoEmpl < 10000),
    'Nom' varchar(25) DEFAULT NULL,
    'Prenom' varchar(25) DEFAULT NULL,
    'NoTelMaison' varchar(15) DEFAULT NULL,
    'NoTelTravail' varchar(21) DEFAULT NULL,
    'NoTelCellulaire' varchar(15) DEFAULT NULL,
    'Modification' DATE DEFAULT NULL,
    'AutreInfos' varchar(50) DEFAULT NULL,
    PRIMARY KEY (`NoUtilisateur`),
);

DROP TABLE IF EXISTS 'connexions';
CREATE TABLE 'connexions'(
    'NoConnexion' int AUTO_INCREMENT CHECK (NoConnexion > 0 && NoConnexion < 10000),
    'NoUtilisateur' int DEFAULT NULL CHECK (NoUtilisateur > 0 && NoUtilisateur < 1000), --cle secondaire
    'Connexion' DATE current_date,
    'Deconnexion' DATE DEFAULT NULL,
    PRIMARY KEY (`NoConnexion`),
    CONSTRAINT `NoUtilisateur` FOREIGN KEY (`NoUtilisateur`) REFERENCES `utilisateurs` (`NoUtilisateur`) ON DELETE CASCADE,
);

DROP TABLE IF EXISTS 'annonces';
CREATE TABLE 'annonces'(
    'NoAnnonce' int AUTO_INCREMENT CHECK (NoAnnonce > 0 && NoAnnonce < 10000),
    'NoUtilisateur' int DEFAULT NULL CHECK (NoUtilisateur > 0 && NoUtilisateur < 1000), --cle secondaire
    'Parution' DATE current_date,
    'Categorie' int DEFAULT NULL, --cle secondaire ref table categories
    'DescritpionAbregee' varchar(50) DEFAULT NULL, --utiliser mysqli_real_escape_string ou le prepare() de PDO
    'DescriptionComplete' varchar(255) DEFAULT NULL, --utiliser mysqli_real_escape_string ou le prepare() de PDO
    'Prix' SMALLMONEY DEFAULT NULL CHECK (Prix >= 0 && Prix < 100000), --afficher à donner si prix = 0
    'Photo' varchar(50) DEFAULT NULL, --mettre les photos dans le fichier photos-annonces
    'MiseAJour' DATE DEFAULT NULL,
    'Etat' int DEFAULT NULL,
    PRIMARY KEY (`NoAnnonce`),
    CONSTRAINT `NoUtilisateur` FOREIGN KEY (`NoUtilisateur`) REFERENCES `utilisateurs` (`NoUtilisateur`) ON DELETE CASCADE,
    CONSTRAINT `Categorie` FOREIGN KEY (`Categorie`) REFERENCES `categories` (`NoCategorie`) ON DELETE CASCADE,

    
);

DROP TABLE IF EXISTS 'categories';
CREATE TABLE 'categories'(
    'NoCategorie' int AUTO_INCREMENT,
    'Description' varchar(20) DEFAULT NULL,
    PRIMARY KEY (`NoCategorie`),
);
