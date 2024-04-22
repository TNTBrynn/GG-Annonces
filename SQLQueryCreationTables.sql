DROP DATABASE IF EXISTS progweb_pjf_glms;
CREATE DATABASE IF NOT EXISTS progweb_pjf_glms;
USE progweb_pjf_glms;

DROP TABLE IF EXISTS utilisateurs;
CREATE TABLE utilisateurs(
    NoUtilisateur INT NOT NULL AUTO_INCREMENT,
    Courriel varchar(50) DEFAULT NULL,
    MotDePasse varchar(15) DEFAULT NULL,
    Creation DATE DEFAULT CURRENT_TIMESTAMP,
    NbConnexions int DEFAULT 0,
    Statut int DEFAULT 0,
    NoEmpl int,
    Nom varchar(25) DEFAULT NULL,
    Prenom varchar(25) DEFAULT NULL,
    NoTelMaison varchar(15) DEFAULT NULL,
    NoTelTravail varchar(21) DEFAULT NULL,
    NoTelCellulaire varchar(15) DEFAULT NULL,
    Modification DATE DEFAULT NULL,
    AutreInfos varchar(50) DEFAULT NULL,
    PRIMARY KEY (NoUtilisateur)
);

DROP TABLE IF EXISTS connexions;
CREATE TABLE connexions(
    NoConnexion int AUTO_INCREMENT,
    NoUtilisateur int DEFAULT NULL,
    Connexion DATE DEFAULT CURRENT_TIMESTAMP,
    Deconnexion DATE DEFAULT NULL,
    PRIMARY KEY (NoConnexion),
    CONSTRAINT FK_NoUtilisateur_Connexions FOREIGN KEY (NoUtilisateur) REFERENCES utilisateurs (NoUtilisateur) ON DELETE CASCADE
);

DROP TABLE IF EXISTS annonces;
CREATE TABLE annonces(
    NoAnnonce int AUTO_INCREMENT,
    NoUtilisateur int DEFAULT NULL,
    Parution DATE DEFAULT CURRENT_TIMESTAMP,
    Categorie int DEFAULT NULL,
    DescritpionAbregee varchar(50) DEFAULT NULL,
    DescriptionComplete varchar(255) DEFAULT NULL,
    Prix DECIMAL(10,2) DEFAULT NULL,
    Photo varchar(50) DEFAULT NULL,
    MiseAJour DATE DEFAULT NULL,
    Etat int DEFAULT NULL,
    PRIMARY KEY (NoAnnonce),
    CONSTRAINT FK_NoUtilisateur_Annonces FOREIGN KEY (NoUtilisateur) REFERENCES utilisateurs (NoUtilisateur) ON DELETE CASCADE
);

DROP TABLE IF EXISTS categories;
CREATE TABLE categories(
    NoCategorie int AUTO_INCREMENT,
    Description varchar(20) DEFAULT NULL,
    PRIMARY KEY (NoCategorie)
);

ALTER TABLE annonces ADD CONSTRAINT FK_Categorie_Annonces FOREIGN KEY (Categorie) REFERENCES categories (NoCategorie) ON DELETE CASCADE;