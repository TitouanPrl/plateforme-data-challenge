DROP DATABASE IF EXISTS SiteWeb;

CREATE DATABASE SiteWeb;
USE SiteWeb;


CREATE TABLE Utilisateur(
	idUser INTEGER(3) PRIMARY KEY auto_increment,
	nom VARCHAR(30),
    prenom VARCHAR(30),
    entreprise VARCHAR(30),
    numTel VARCHAR(16),
    email VARCHAR(250),
    mdp VARCHAR(30)
);

CREATE TABLE Equipe(
    idEquipe INTEGER(3) PRIMARY KEY auto_increment,
    capitaine INTEGER(3),
    m2 INTEGER(3) DEFAULT NULL, -- membre de l'équipe numéro 2
    m3 INTEGER(3) DEFAULT NULL,
    m4 INTEGER(3) DEFAULT NULL,
    m5 INTEGER(3) DEFAULT NULL,
    m6 INTEGER(3) DEFAULT NULL,
    m7 INTEGER(3) DEFAULT NULL,
    m8 INTEGER(3) DEFAULT NULL
);

CREATE TABLE Message (
    idMessage INTEGER(3) PRIMARY KEY auto_increment,
    contenu VARCHAR(250),
    idExpediteur INTEGER(3),
    idDestinataire INTEGER(3)
);

CREATE TABLE Questionnaire (
    idQuestionnaire INTEGER(3) PRIMARY KEY,
    idSujet INTEGER(3),
    FOREIGN KEY (idSujet) REFERENCES Sujet (idSujet)
);

CREATE TABLE Question (
    idQuestion INTEGER(3) PRIMARY KEY,
    contenu VARCHAR(250),
    idQuestionnaire INTEGER(3),
    FOREIGN KEY (idQuestionnaire) REFERENCES Questionnaire (idQuestionnaire)
);

CREATE TABLE Réponse (
    idReponse INTEGER(3) PRIMARY KEY,
    contenu VARCHAR(1024),
    idQuestion INTEGER(3),
    idEquipe INTEGER(3),
    FOREIGN KEY (idQuestion) REFERENCES Question (idQuestion),
    FOREIGN KEY (idEquipe) REFERENCES Equipe (idEquipe)
);

CREATE TABLE Podium (
    idPodium INTEGER(3) PRIMARY KEY,
    idE1 INTEGER(3) DEFAULT NULL,
    idE2 INTEGER(3) DEFAULT NULL,
    idE3 INTEGER(3) DEFAULT NULL,
    idSujet INTEGER(3),
    FOREIGN KEY (idSujet) REFERENCES Sujet (idSujet)

);

CREATE TABLE Projet (
    idProjet INTEGER(3) PRIMARY KEY,
    idEquipe INTEGER(3),
    idSujet INTEGER(3),
    lienCode VARCHAR(250),
    FOREIGN KEY (idEquipe) REFERENCES Equipe (idEquipe),
    FOREIGN KEY (idUser) REFERENCES Sujet (idSujet)
);

CREATE TABLE Sujet (
    idSujet INTEGER(3) PRIMARY KEY,
    idEvenement INTEGER(3),
    libelle VARCHAR(30),
    descrip VARCHAR(250),
    img VARCHAR(250),
    telGerant VARCHAR(16),
    emailGerant VARCHAR(250),
    lienResources VARCHAR(250),
    FOREIGN KEY (idEvenement) REFERENCES Evenement (idEvenement)
);

CREATE TABLE Evenement (
    idEvenement INT PRIMARY KEY,
    libelle VARCHAR(30),
    dateD DATETIME,
    dateF DATETIME
);
