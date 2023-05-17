DROP DATABASE IF EXISTS SiteWeb;

CREATE DATABASE SiteWeb;
USE SiteWeb;


CREATE TABLE Utilisateur(
	idUser INT PRIMARY KEY,
	nom VARCHAR(30),
    prenom VARCHAR(30),
    entreprise VARCHAR(30),
    numTel VARCHAR(13),
    email VARCHAR(250),
    mdp VARCHAR(30)
);

CREATE TABLE Equipe(
    idEquipe INT PRIMARY KEY,
    capitaine INT,
    m2 INT DEFAULT NULL, -- membre de l'équipe numéro 2
    m3 INT DEFAULT NULL,
    m4 INT DEFAULT NULL,
    m5 INT DEFAULT NULL,
    m6 INT DEFAULT NULL,
    m7 INT DEFAULT NULL,
    m8 INT DEFAULT NULL
);

CREATE TABLE Message (
    idMessage INT PRIMARY KEY,
    contenu VARCHAR(250),
    idExpediteur INT,
    idDestinataire INT
);

CREATE TABLE Questionnaire (
    idQuestionnaire INT PRIMARY KEY,
    lienForm VARCHAR(250)
);

CREATE TABLE Podium (
    idPodium INT PRIMARY KEY,
    idE1 INT DEFAULT NULL,
    idE2 INT DEFAULT NULL,
    idE3 INT DEFAULT NULL,
    idSujet INT,
    FOREIGN KEY (idSujet) REFERENCES ProjetData (idSujet)

);

CREATE TABLE ProjetEtudiant (
    idProjet INT PRIMARY KEY,
    idEquipe INT,
    idSujet int,
    lienCode VARCHAR(250),
    FOREIGN KEY (idEquipe) REFERENCES Equipe (idEquipe),
    FOREIGN KEY (idUser) REFERENCES ProjetData (idSujet)
);

CREATE TABLE ProjetData (
    idSujet INT PRIMARY KEY,
    idChallenge INT,
    libelle VARCHAR(30),
    descrip VARCHAR(250),
    img VARCHAR(250),
    telGerant INT,
    emailGerant VARCHAR(250),
    lienResources VARCHAR(250),
    FOREIGN KEY (idChallenge) REFERENCES DataChallenge (idChallenge)
);

CREATE TABLE DataChallenge (
    idChallenge INT PRIMARY KEY,
    libelle VARCHAR(30),
    dateD DATETIME,
    dateF DATETIME
);
