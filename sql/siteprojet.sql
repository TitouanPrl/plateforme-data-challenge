DROP DATABASE IF EXISTS SiteProjet;

CREATE DATABASE SiteProjet;
USE SiteProjet;


CREATE TABLE Evenement (
    idEvenement INT PRIMARY KEY auto_increment,
    kind VARCHAR(30), /* CHALLENGE OU BATTLE */
    libelle VARCHAR(30),
    descrip VARCHAR(1024),
    dateD DATE,
    dateF DATE
);

CREATE TABLE Equipe(
    idEquipe INTEGER PRIMARY KEY auto_increment,
    idEvenement INTEGER,
    nom VARCHAR(64),
    capitaine INTEGER,
    FOREIGN KEY (idEvenement) REFERENCES Evenement (idEvenement) on delete cascade
);

CREATE TABLE Utilisateur(
	idUser INTEGER PRIMARY KEY auto_increment,
	nom VARCHAR(30),
    prenom VARCHAR(30),
    entreprise VARCHAR(30),
    numTel VARCHAR(16),
    email VARCHAR(250),
    nivEtude VARCHAR(64),
    ecole VARCHAR(64),
    ville VARCHAR(64),
    mdp VARCHAR(256),
    dateD DATE,
    dateF DATE,
    idEquipe INTEGER,
    fonction VARCHAR(16),   /* ADMIN/GESTION/USER */
    FOREIGN KEY (idEquipe) REFERENCES Equipe (idEquipe)
);


CREATE TABLE Messages (
    idMessage INTEGER PRIMARY KEY auto_increment,
    contenu VARCHAR(250),
    idExpediteur INTEGER,
    idDestinataire INTEGER,
    FOREIGN KEY (idExpediteur) REFERENCES Utilisateur (idUser) on delete cascade,
    FOREIGN KEY (idDestinataire) REFERENCES Utilisateur (idUser) on delete cascade
);

CREATE TABLE Conversation (
    idConversation INTEGER PRIMARY KEY auto_increment,
    idExpediteur INTEGER,
    idDestinataire INTEGER,
    FOREIGN KEY (idExpediteur) REFERENCES Utilisateur (idUser),
    FOREIGN KEY (idDestinataire) REFERENCES Utilisateur (idUser)
);

CREATE TABLE Sujet (
    idSujet INTEGER PRIMARY KEY auto_increment,
    idEvenement INTEGER,
    libelle VARCHAR(30),
    descrip VARCHAR(1024),
    img VARCHAR(250),
    telGerant VARCHAR(16),
    emailGerant VARCHAR(250),
    lienRessources VARCHAR(250),
    -- équipes du podium
    idE1 INTEGER DEFAULT NULL,
    idE2 INTEGER DEFAULT NULL, 
    idE3 INTEGER DEFAULT NULL,
    FOREIGN KEY (idEvenement) REFERENCES Evenement (idEvenement) on delete cascade
);

/* Gère les liaisons participant-event et gestionnaire-event */
CREATE TABLE Inscription (
    idUser INTEGER,
    idEvenement INTEGER,
    PRIMARY KEY (idUser,idEvenement),
    FOREIGN KEY (idUser) REFERENCES Utilisateur (idUser) on delete cascade,
    FOREIGN KEY (idEvenement) REFERENCES Evenement (idEvenement) on delete cascade
);


CREATE TABLE Projet (
    idProjet INTEGER PRIMARY KEY auto_increment,
    idEquipe INTEGER,
    idSujet INTEGER,
    lienCode VARCHAR(250),
    jsonStatistiques JSON,
    FOREIGN KEY (idEquipe) REFERENCES Equipe (idEquipe) on delete cascade,
    FOREIGN KEY (idSujet) REFERENCES Sujet (idSujet) on delete cascade
);

CREATE TABLE Questionnaire (
    idQuestionnaire INTEGER PRIMARY KEY auto_increment,
    idEvenement INTEGER,
    dateD DATETIME,
    dateF DATETIME,
    FOREIGN KEY (idEvenement) REFERENCES Evenement (idEvenement) on delete cascade
);

CREATE TABLE Question (
    idQuestion INTEGER PRIMARY KEY auto_increment,
    contenu VARCHAR(250),
    idQuestionnaire INTEGER,
    FOREIGN KEY (idQuestionnaire) REFERENCES Questionnaire (idQuestionnaire) on delete cascade
);

CREATE TABLE Reponse (
    idReponse INTEGER PRIMARY KEY auto_increment,
    contenu VARCHAR(1024),
    idQuestion INTEGER,
    idEquipe INTEGER,
    note INTEGER DEFAULT NULL,
    FOREIGN KEY (idQuestion) REFERENCES Question (idQuestion) on delete cascade,
    FOREIGN KEY (idEquipe) REFERENCES Equipe (idEquipe) on delete cascade
);



INSERT INTO Utilisateur (nom,prenom,numTel,email,nivEtude,ecole,ville,mdp,fonction) VALUES ("Archibald","Haddock",0782778266,"hh@gmail.com","1ère année de Master","la mer","Mauléon","ab4f63f9ac65152575886860dde480a1","USER");
INSERT INTO Utilisateur (nom,prenom,numTel,email,nivEtude,ecole,ville,mdp,fonction) VALUES ("Rastapopoulos","Monsieur",0782778266,"rp@gmail.com","1ère année de Master","l'école des méchants","Lyon","ab4f63f9ac65152575886860dde480a1","USER");
INSERT INTO Utilisateur (nom,prenom,numTel,email,nivEtude,ecole,ville,mdp,fonction) VALUES ("Castafiore","Bianca",0782778266,"bc@gmail.com","1ère année de Master","Conservatoire","Barcelone","ab4f63f9ac65152575886860dde480a1","USER");
INSERT INTO Utilisateur (nom,prenom,numTel,entreprise,email,mdp,fonction) VALUES ("Tournesol","Tryphon",0782778266,"Laboratoire de Genève","gestion@gmail.com","ab4f63f9ac65152575886860dde480a1","GESTION");
INSERT INTO Utilisateur (nom,prenom,numTel,entreprise,email,mdp,fonction) VALUES ("Pradal","Titouan",0782778266,"Laboratoire de Genève","pradaltito@cy-tech.fr","ab4f63f9ac65152575886860dde480a1","USER");
INSERT INTO Utilisateur (nom,prenom,numTel,entreprise,email,mdp,fonction) VALUES ("Depreter","Rémi",0782778266,"Laboratoire de Genève","remi@cy-tech.fr","ab4f63f9ac65152575886860dde480a1","USER");
INSERT INTO Utilisateur (nom,prenom,numTel,entreprise,email,mdp,fonction) VALUES ("Galloy","Clémentine",0782778266,"Laboratoire de Genève","clementine@cy-tech.fr","ab4f63f9ac65152575886860dde480a1","USER");
INSERT INTO Utilisateur (nom,prenom,numTel,entreprise,email,mdp,fonction) VALUES ("Galloy","Jappy",0782778266,"Laboratoire de Genève","jg@cy-tech.fr","ab4f63f9ac65152575886860dde480a1","USER");
INSERT INTO Utilisateur (nom,prenom,numTel,entreprise,email,mdp,fonction) VALUES ("Galloy","Elvis",0782778266,"Laboratoire de Genève","admin@cy-tech.fr","ab4f63f9ac65152575886860dde480a1","ADMIN");
INSERT INTO Utilisateur (nom,prenom,numTel,entreprise,email,mdp,fonction) VALUES ("Lallinec","Naiwann",0782778266,"Laboratoire de Genève","naiwann@cy-tech.fr","ab4f63f9ac65152575886860dde480a1","USER");



INSERT INTO Evenement (kind,libelle,descrip) VALUES ("CHALLENGE","Le lotus bleu","Grand prix de code de Chine");
INSERT INTO Evenement (kind,libelle,descrip) VALUES ("BATTLE","Le sceptre d'Ottokar","Retrouvez le sceptre perdu sur le web");

INSERT INTO Sujet (idEvenement,libelle,descrip,img,telGerant,emailGerant,lienRessources) VALUES (1,"Les requins baleines","Etudier les requins baleins", "../../img/mountain_bg.jpeg",0606060606,"rb@gmail.com","https://www.nausicaa.fr/fiches-animaux/requin-baleine/");
INSERT INTO Sujet (idEvenement,libelle,descrip,img,telGerant,emailGerant,lienRessources) VALUES (1,"Les orques","Étude des orques", "../../img/mountain_bg.jpeg",0606060606,"ok@gmail.com","https://www.nationalgeographic.fr/thematique/sujet/animaux/mammiferes/mammiferes-marins/dauphin/orque");
INSERT INTO Sujet (idEvenement,libelle,descrip,img,telGerant,emailGerant,lienRessources,idE1,idE2) VALUES (2,"Le sceptre","Sa majesté compte sur vous...", "../../img/mountain_bg.jpeg",0606060606,"so@gmail.com","https://www.casterman.com/Bande-dessinee/Catalogue/le-sceptre-dottokar/9782203001077",1,2);

INSERT INTO Inscription (idUser,idEvenement) VALUES (1,1);
INSERT INTO Inscription (idUser,idEvenement) VALUES (2,2);
INSERT INTO Inscription (idUser,idEvenement) VALUES (3,2);
INSERT INTO Inscription (idUser,idEvenement) VALUES (5,1);
INSERT INTO Inscription (idUser,idEvenement) VALUES (6,1);
INSERT INTO Inscription (idUser,idEvenement) VALUES (7,2);
INSERT INTO Inscription (idUser,idEvenement) VALUES (1,2);
INSERT INTO Inscription (idUser,idEvenement) VALUES (5,2);
INSERT INTO Inscription (idUser,idEvenement) VALUES (6,2);
INSERT INTO Inscription (idUser,idEvenement) VALUES (8,2);
INSERT INTO Inscription (idUser,idEvenement) VALUES (4,2);


INSERT INTO Equipe (nom,capitaine,idEvenement) VALUES ("les loulous",1,1);
INSERT INTO Equipe (nom,capitaine,idEvenement) VALUES ("les winner",5,2);

UPDATE Utilisateur SET idEquipe = 1 WHERE idUser=1;
UPDATE Utilisateur SET idEquipe = 2 WHERE idUser=2;
UPDATE Utilisateur SET idEquipe = 2 WHERE idUser=3;
UPDATE Utilisateur SET idEquipe = 2 WHERE idUser=5;
UPDATE Utilisateur SET idEquipe = 2 WHERE idUser=6;

INSERT INTO Questionnaire (idEvenement) VALUES (1);
INSERT INTO Questionnaire (idEvenement) VALUES (2);

INSERT INTO Projet (idEquipe, idSujet) VALUES (2, 3);

