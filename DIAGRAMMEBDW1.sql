-- First check if the table exists not possible here (no right to delete foreign key constraint)

	
CREATE TABLE Quartiers (idQ int AUTO_INCREMENT NOT NULL,
nomQ varchar(255)(255),
codeInsee int,
coords varchar(255),
typeQ varchar(255),
idC int,
PRIMARY KEY (idQ));

CREATE TABLE Departement (idD int(100) AUTO_INCREMENT NOT NULL,
PRIMARY KEY (idD));

CREATE TABLE Commune (idC int AUTO_INCREMENT NOT NULL,
nomC varchar(255),
cpCommune varchar(255),
idD int,
PRIMARY KEY (idC));

CREATE TABLE Routes (idRint AUTO_INCREMENT NOT NULL,
nomR varchar(255),
typeTransport varchar(255),
idQ int ,
idQ_ARRIVER int,
PRIMARY KEY (idR));

CREATE TABLE Partie (idPartieint AUTO_INCREMENT NOT NULL,
dateDemarage DATE,
nbDetecgives INT,
idConfigurationint AUTO_INCREMENT,
PRIMARY KEY (idPartie));

CREATE TABLE Joueuses (idJint AUTO_INCREMENT NOT NULL,
nomJ varchar(255),
emailJ varchar(255),
PRIMARY KEY (idJ));

CREATE TABLE Configuration (idConfigurationint AUTO_INCREMENT NOT NULL,
nomConfiguration varchar(255),
dateConfiguratiion date,
strategieConfiguration enum('basique', 'économe', 'pistage')),
PRIMARY KEY (idConfiguration));

CREATE TABLE Image (idI int AUTO_INCREMENT NOT NULL,
nomI varchar(255),
cheminImage varchar(255),
PRIMARY KEY (idI));

CREATE TABLE ToursMisterX (idMint AUTO_INCREMENT NOT NULL,
idR int,
PRIMARY KEY (idM));

CREATE TABLE Victoire (idV int AUTO_INCREMENT NOT NULL,
PRIMARY KEY (idV));

CREATE TABLE Participe (idJ int AUTO_INCREMENT NOT NULL,
idPartieint AUTO_INCREMENT NOT NULL,
idV int NOT NULL,
PRIMARY KEY (idJ, idPartie, idV_Victoire));

CREATE TABLE Inclus (idI int AUTO_INCREMENT NOT NULL,
idConfigurationint int NOT NULL,
PRIMARY KEY (idI, idConfiguration));

ALTER TABLE Quartiers ADD CONSTRAINT FK_Quartiers_idC FOREIGN KEY (idC) REFERENCES Commune (idC);
ALTER TABLE Commune ADD CONSTRAINT FK_Commune_idD FOREIGN KEY (idD) REFERENCES Departement (idD);
ALTER TABLE Routes ADD CONSTRAINT FK_Routes_idQ FOREIGN KEY (idQ) REFERENCES Quartiers (idQ);
ALTER TABLE Routes ADD CONSTRAINT FK_Routes_idQ_ARRIVER FOREIGN KEY (idQ_ARRIVER) REFERENCES Quartiers (idQ);
ALTER TABLE Partie ADD CONSTRAINT FK_Partie_idConfiguration FOREIGN KEY (idConfiguration) REFERENCES Configuration (idConfiguration);
ALTER TABLE ToursMisterX ADD CONSTRAINT FK_ToursMisterX_idR FOREIGN KEY (idR) REFERENCES Routes (idR);
ALTER TABLE Participe ADD CONSTRAINT FK_Participe_idJ FOREIGN KEY (idJ) REFERENCES Joueuses (idJ);
ALTER TABLE Participe ADD CONSTRAINT FK_Participe_idPartie FOREIGN KEY (idPartie) REFERENCES Partie (idPartie);
ALTER TABLE Participe ADD CONSTRAINT FK_Participe_idV FOREIGN KEY (idV) REFERENCES Victoire (idV);
ALTER TABLE Inclus ADD CONSTRAINT FK_Inclus_idI FOREIGN KEY (idI) REFERENCES Image (idI);
ALTER TABLE Inclus ADD CONSTRAINT FK_Inclus_idConfiguration FOREIGN KEY (idConfiguration) REFERENCES Configuration (idConfiguration);
