DROP DATABASE IF EXISTS SiteWeb;

CREATE DATABASE SiteWeb;
USE SiteWeb;


CREATE TABLE Utilisateur(
	idUser INTEGER PRIMARY KEY auto_increment,
	nom VARCHAR(30),
    prenom VARCHAR(30),
    entreprise VARCHAR(30),
    numTel VARCHAR(16),
    email VARCHAR(250),
    nivEtude VARCHAR(16),
    ecole VARCHAR(64),
    ville VARCHAR(64),
    mdp VARCHAR(256),
    dateD DATETIME,
    dateF DATETIME,
    fonction VARCHAR(16)   /* ADMIN/GESTION/USER */
);

CREATE TABLE Equipe(
    idEquipe INTEGER PRIMARY KEY auto_increment,
    nom VARCHAR(64),
    capitaine INTEGER,
    m2 INTEGER DEFAULT NULL, -- membre de l'équipe numéro 2
    m3 INTEGER DEFAULT NULL,
    m4 INTEGER DEFAULT NULL,
    m5 INTEGER DEFAULT NULL,
    m6 INTEGER DEFAULT NULL,
    m7 INTEGER DEFAULT NULL,
    m8 INTEGER DEFAULT NULL
);

CREATE TABLE Message (
    idMessage INTEGER PRIMARY KEY auto_increment,
    contenu VARCHAR(250),
    idExpediteur INTEGER,
    idDestinataire INTEGER
);

CREATE TABLE Evenement (
    idEvenement INT PRIMARY KEY,
    libelle VARCHAR(30),
    descrip VARCHAR(1024),
    dateD DATETIME,
    dateF DATETIME
);

CREATE TABLE Sujet (
    idSujet INTEGER PRIMARY KEY,
    idEvenement INTEGER,
    libelle VARCHAR(30),
    descrip VARCHAR(1024),
    img VARCHAR(250),
    telGerant VARCHAR(16),
    emailGerant VARCHAR(250),
    lienResources VARCHAR(250),
    FOREIGN KEY (idEvenement) REFERENCES Evenement (idEvenement) on delete cascade
);

CREATE TABLE Projet (
    idProjet INTEGER PRIMARY KEY,
    idEquipe INTEGER,
    idSujet INTEGER,
    lienCode VARCHAR(250),
    FOREIGN KEY (idEquipe) REFERENCES Equipe (idEquipe) on delete cascade,
    FOREIGN KEY (idSujet) REFERENCES Sujet (idSujet) on delete cascade
);

CREATE TABLE Podium (
    idPodium INTEGER PRIMARY KEY,
    idE1 INTEGER DEFAULT NULL,
    idE2 INTEGER DEFAULT NULL,
    idE3 INTEGER DEFAULT NULL,
    idSujet INTEGER,
    FOREIGN KEY (idSujet) REFERENCES Sujet (idSujet) on delete cascade

);

CREATE TABLE Questionnaire (
    idQuestionnaire INTEGER PRIMARY KEY auto_increment,
    idSujet INTEGER,
    FOREIGN KEY (idSujet) REFERENCES Sujet (idSujet) on delete cascade
);

CREATE TABLE Question (
    idQuestion INTEGER PRIMARY KEY auto_increment,
    contenu VARCHAR(250),
    idQuestionnaire INTEGER,
    FOREIGN KEY (idQuestionnaire) REFERENCES Questionnaire (idQuestionnaire) on delete cascade
);

CREATE TABLE Réponse (
    idReponse INTEGER PRIMARY KEY auto_increment,
    contenu VARCHAR(1024),
    idQuestion INTEGER,
    idEquipe INTEGER,
    FOREIGN KEY (idQuestion) REFERENCES Question (idQuestion) on delete cascade,
    FOREIGN KEY (idEquipe) REFERENCES Equipe (idEquipe) on delete cascade
);


