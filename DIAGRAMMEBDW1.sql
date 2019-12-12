-- First check if the table exists not possible here (no right to delete foreign key constraint)
DROP TABLE IF EXISTS Contient;
DROP TABLE IF EXISTS Geometries;
DROP TABLE IF EXISTS Inclus;
DROP TABLE IF EXISTS Participe;
DROP TABLE IF EXISTS ToursMisterX;
DROP TABLE IF EXISTS Image;
DROP TABLE IF EXISTS Joueuses;
DROP TABLE IF EXISTS Partie;
DROP TABLE IF EXISTS Configuration;
DROP TABLE IF EXISTS Routes;
DROP TABLE IF EXISTS Transport;
DROP TABLE IF EXISTS Quartiers;
DROP TABLE IF EXISTS Commune;
DROP TABLE IF EXISTS Departement;

CREATE TABLE Quartiers (idQ int AUTO_INCREMENT NOT NULL,
nomQ varchar(255),
codeInsee int,
typeQ varchar(255),
nomCommune varchar(255),
PRIMARY KEY (idQ));

CREATE TABLE Commune (departement int NOT NULL,
nomCommune varchar(255),
cpCommune varchar(255),
PRIMARY KEY (nomCommune));

CREATE TABLE Routes (
idQ_DEPART int,
idQ_ARRIVER int,
typeTransport varchar(255),
PRIMARY KEY (idQ_DEPART, idQ_ARRIVER, typeTransport));

CREATE TABLE Transport (
typeTransport varchar(255),
PRIMARY KEY (typeTransport));

CREATE TABLE Partie (idPartie int AUTO_INCREMENT NOT NULL,
dateDemarage DATE,
nbDetectives INT,
idConfiguration int,
PRIMARY KEY (idPartie));

CREATE TABLE Joueuses (idJ int AUTO_INCREMENT NOT NULL,
nomJ varchar(255),
emailJ varchar(255),
PRIMARY KEY (idJ));

CREATE TABLE Configuration (idConfiguration int AUTO_INCREMENT NOT NULL,
nomConfiguration varchar(255),
dateConfiguration date,
strategieConfiguration enum('basique', 'économe', 'pistage'),
ensembleImages varchar(255),
PRIMARY KEY (idConfiguration));

CREATE TABLE Image (idI int AUTO_INCREMENT NOT NULL,
nomI varchar(255),
cheminImage varchar(255),
PRIMARY KEY (idI));

CREATE TABLE ToursMisterX (idPartie int NOT NULL,
nbTours int, 
idQ_DEPART int,
idQ_ARRIVER int,
typeTransport varchar(255),
PRIMARY KEY (idPartie, nbTours));

CREATE TABLE Geometries (latitude int NOT NULL,
						 longitude int, 
						 idQ int, 
						 PRIMARY KEY (latitude, longitude));

CREATE TABLE Participe (idPartie int NOT NULL,
nomJ varchar(255),
victoire_PARTICIPE varchar(255),
PRIMARY KEY (idPartie));

CREATE TABLE Inclus (idI int AUTO_INCREMENT NOT NULL,
idConfiguration int NOT NULL,
PRIMARY KEY (idI, idConfiguration));

ALTER TABLE Quartiers ADD CONSTRAINT FK_Quartiers_nomCommune FOREIGN KEY (nomCommune) REFERENCES Commune (nomCommune);
ALTER TABLE Routes ADD CONSTRAINT FK_Routes_idQ_DEPART FOREIGN KEY (idQ_DEPART) REFERENCES Quartiers (idQ);
ALTER TABLE Routes ADD CONSTRAINT FK_Routes_idQ_ARRIVER FOREIGN KEY (idQ_ARRIVER) REFERENCES Quartiers (idQ);
ALTER TABLE Routes ADD CONSTRAINT FK_Routes_typeTransport FOREIGN KEY (typeTransport) REFERENCES Transport (typeTransport);
ALTER TABLE Partie ADD CONSTRAINT FK_Partie_idConfiguration FOREIGN KEY (idConfiguration) REFERENCES Configuration (idConfiguration);
ALTER TABLE ToursMisterX ADD CONSTRAINT FK_ToursMisterX_idQ_ARRIVER FOREIGN KEY (idQ_ARRIVER) REFERENCES Routes (idQ_ARRIVER);
ALTER TABLE ToursMisterX ADD CONSTRAINT FK_ToursMisterX_idQ_DEPART FOREIGN KEY (idQ_DEPART) REFERENCES Routes (idQ_DEPART);
ALTER TABLE ToursMisterX ADD CONSTRAINT FK_ToursMisterX_typeTransport FOREIGN KEY (typeTransport) REFERENCES Transport (typeTransport);
ALTER TABLE ToursMisterX ADD CONSTRAINT FK_ToursMisterX_idPartie FOREIGN KEY (idPartie) REFERENCES Partie (idPartie);
ALTER TABLE Geometries ADD CONSTRAINT FK_Geometries_idQ FOREIGN KEY (idQ) REFERENCES Quartiers (idQ);
ALTER TABLE Participe ADD CONSTRAINT FK_Participe_idPartie FOREIGN KEY (idPartie) REFERENCES Partie (idPartie);
ALTER TABLE Inclus ADD CONSTRAINT FK_Inclus_idI FOREIGN KEY (idI) REFERENCES Image (idI);
ALTER TABLE Inclus ADD CONSTRAINT FK_Inclus_idConfiguration FOREIGN KEY (idConfiguration) REFERENCES Configuration (idConfiguration);

INSERT INTO Commune (departement, nomCommune, cpCommune) 
SELECT dsq.departement, dsq.nomCommune AS nomCommune, dsq.cpCommune
FROM   dataset.Quartiers dsq
GROUP BY dsq.cpCommune;

INSERT INTO Quartiers (idQ, codeInsee, typeQ, nomQ, nomCommune) 
SELECT dsq.idQ, dsq.codeInsee, dsq.typeQ, dsq.nomQ, dsq.nomCommune
FROM   dataset.Quartiers dsq;

INSERT INTO Transport (typeTransport)
SELECT DISTINCT transport 
FROM dataset.Routes;

INSERT INTO Routes (idQ_DEPART, typeTransport, idQ_ARRIVER)
SELECT idQuartierDepart, transport, idQuartierArrivee
FROM dataset.Routes
