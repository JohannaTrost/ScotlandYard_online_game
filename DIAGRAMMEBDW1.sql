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

CREATE TABLE Routes (idR int AUTO_INCREMENT NOT NULL,
typeTransport varchar(255),
idQ_DEPART int,
idQ_ARRIVER int,
PRIMARY KEY (idR));

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
PRIMARY KEY (idConfiguration));

CREATE TABLE Image (idI int AUTO_INCREMENT NOT NULL,
nomI varchar(255),
cheminImage varchar(255),
PRIMARY KEY (idI));

CREATE TABLE ToursMisterX (idM int AUTO_INCREMENT NOT NULL,
idR int,
PRIMARY KEY (idM));

CREATE TABLE Geometries (latitude int NOT NULL,
						 longitude int, 
						 idQ int, 
						 PRIMARY KEY (latitude, longitude));

CREATE TABLE Participe (idJ int NOT NULL,
idPartie int NOT NULL,
victoire_PARTICIPE int,
PRIMARY KEY (idJ, idPartie));

CREATE TABLE Inclus (idI int AUTO_INCREMENT NOT NULL,
idConfiguration int NOT NULL,
PRIMARY KEY (idI, idConfiguration));

CREATE TABLE Contient (idM int NOT NULL, 
						idPartie int NOT NULL, 
						PRIMARY KEY (idM,  idPartie));

ALTER TABLE Quartiers ADD CONSTRAINT FK_Quartiers_nomCommune FOREIGN KEY (nomCommune) REFERENCES Commune (nomCommune);
ALTER TABLE Routes ADD CONSTRAINT FK_Routes_idQ_DEPART FOREIGN KEY (idQ_DEPART) REFERENCES Quartiers (idQ);
ALTER TABLE Routes ADD CONSTRAINT FK_Routes_idQ_ARRIVER FOREIGN KEY (idQ_ARRIVER) REFERENCES Quartiers (idQ);
ALTER TABLE Partie ADD CONSTRAINT FK_Partie_idConfiguration FOREIGN KEY (idConfiguration) REFERENCES Configuration (idConfiguration);
ALTER TABLE ToursMisterX ADD CONSTRAINT FK_ToursMisterX_idR FOREIGN KEY (idR) REFERENCES Routes (idR);
ALTER TABLE Geometries ADD CONSTRAINT FK_Geometries_idQ FOREIGN KEY (idQ) REFERENCES Quartiers (idQ);
ALTER TABLE Participe ADD CONSTRAINT FK_Participe_idJ FOREIGN KEY (idJ) REFERENCES Joueuses (idJ);
ALTER TABLE Participe ADD CONSTRAINT FK_Participe_idPartie FOREIGN KEY (idPartie) REFERENCES Partie (idPartie);
ALTER TABLE Inclus ADD CONSTRAINT FK_Inclus_idI FOREIGN KEY (idI) REFERENCES Image (idI);
ALTER TABLE Inclus ADD CONSTRAINT FK_Inclus_idConfiguration FOREIGN KEY (idConfiguration) REFERENCES Configuration (idConfiguration);
ALTER TABLE Contient ADD CONSTRAINT FK_Contient_idM FOREIGN KEY (idM) REFERENCES ToursMisterX (idM); 
ALTER TABLE Contient ADD CONSTRAINT FK_Contient_idPartie FOREIGN KEY (idPartie) REFERENCES Partie (idPartie);

INSERT INTO Commune (departement, nomCommune, cpCommune) 
SELECT dsq.departement, dsq.nomCommune AS nomCommune, dsq.cpCommune
FROM   dataset.Quartiers dsq
GROUP BY dsq.cpCommune;

INSERT INTO Quartiers (idQ, codeInsee, typeQ, nomQ, nomCommune) 
SELECT dsq.idQ, dsq.codeInsee, dsq.typeQ, dsq.nomQ, dsq.nomCommune
FROM   dataset.Quartiers dsq;

INSERT INTO Routes (idQ_ARRIVER, typeTransport, idQ_DEPART)
SELECT idQuartierArrivee, transport, idQuartierDepart 
FROM dataset.Routes dsr


--INSERT INTO Routes (idQ_ARRIVER, typeTransport)
--SELECT idQ, transport 
--FROM dataset.Routes dsr JOIN p1925142.Quartiers pq
--ON dsr.idQuartierArrivee = pq.idQ;

--UPDATE p1925142.Routes
--SET idQ =(SELECT idQ  
--FROM dataset.Routes dsr JOIN p1925142.Quartiers pq
--ON dsr.idQuartierDepart = pq.idQ) -> for each idQ do the update 


--ALTER TABLE Routes
--DROP FOREIGN KEY FK_Routes_idQ;
--ALTER TABLE Routes 
--DROP COLUMN idQ;
--ALTER TABLE Routes ADD COLUMN idQ;
--ALTER TABLE Routes ADD CONSTRAINT FK_Routes_idQ FOREIGN KEY (idQ) REFERENCES Quartiers (idQ);
--INSERT INTO Routes (idQ)
--SELECT idQ 
--FROM dataset.Routes dsr JOIN p1925142.Quartiers pq
--ON dsr.idQuartierDepart = pq.idQ;



