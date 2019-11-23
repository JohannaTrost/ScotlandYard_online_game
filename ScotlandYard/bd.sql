/*
** Jeu de données Series_critiques 
** UCB Lyon 1 - BDW1 - Fabien Duchateau - 2018 
*/

/* Dropping existing tables */
DROP TABLE IF EXISTS Critiques;
DROP TABLE IF EXISTS Joue;
DROP TABLE IF EXISTS Actrices; 
DROP TABLE IF EXISTS Episodes; 
DROP TABLE IF EXISTS Saisons; 
DROP TABLE IF EXISTS Series;

/* Creating tables */ 

CREATE TABLE Series ( nomSerie VARCHAR(255), PRIMARY KEY(nomSerie)); 
CREATE TABLE Saisons ( idSaison INTEGER,
dateLancement DATE, nomSerie VARCHAR(255) REFERENCES Series(nomSerie), PRIMARY KEY(idSaison)); 
CREATE TABLE Episodes ( numero INTEGER, idSaison INTEGER REFERENCES Saisons(idSaison), titre VARCHAR(255), PRIMARY KEY(numero, idSaison)); 
CREATE TABLE Actrices ( numINSEE INTEGER, nom VARCHAR(100), prenom VARCHAR(100), PRIMARY KEY(numINSEE)); 
CREATE TABLE Joue ( numero INTEGER REFERENCES Episodes(numero), idSaison INTEGER REFERENCES Saisons(idSaison), numINSEE INTEGER REFERENCES Actrices(numINSEE), salaire DOUBLE, PRIMARY KEY(numero, idSaison, numINSEE)); 
CREATE TABLE Critiques ( idC INTEGER NOT NULL AUTO_INCREMENT, dateC DATETIME, pseudoC VARCHAR(100), texteC VARCHAR(255), nomSerie VARCHAR(255) REFERENCES Series(nomSerie), PRIMARY KEY(idC));

/* Inserting instances */ 
 
INSERT INTO Series VALUES('The Big Bang Theory'); 
INSERT INTO Series VALUES('Game of Thrones');
INSERT INTO Series VALUES('The Wire'); 
INSERT INTO Series VALUES('Breaking Bad'); 
INSERT INTO Saisons VALUES(1, '2011-09-22', 'The Big Bang Theory'); 
INSERT INTO Saisons VALUES(2, '2012-09-27', 'The Big Bang Theory'); 
INSERT INTO Saisons VALUES(3, '2011-04-17', 'Game of Thrones'); 
INSERT INTO Episodes VALUES(1, 1, 'The Skank Reflex Analysis'); 
INSERT INTO Episodes VALUES(1, 2, 'The Date Night Variable'); 
INSERT INTO Episodes VALUES(1, 3, 'Winter is coming'); INSERT INTO Episodes VALUES(2, 3, 'The Kingsroad'); 
INSERT INTO Actrices VALUES(111, 'Bean', 'Sean'); INSERT INTO Actrices VALUES(222, 'Fairley', 'Michelle'); INSERT INTO Actrices VALUES(333, 'Cuoco', 'Kaley'); INSERT INTO Actrices VALUES(444, 'Parsons', 'Jim'); INSERT INTO Joue VALUES(1, 3, 111, NULL); 
INSERT INTO Joue VALUES(1, 3, 222, 6000); 
INSERT INTO Joue VALUES(2, 3, 111, 5437.65); 
INSERT INTO Joue VALUES(2, 3, 222, 6000); 
INSERT INTO Joue VALUES(1, 1, 333, 3200); 
INSERT INTO Joue VALUES(1, 1, 444, 3200); 
INSERT INTO Joue VALUES(1, 2, 333, 3200); 
INSERT INTO Joue VALUES(1, 2, 444, 3200); 
INSERT INTO Critiques VALUES(1, '2012-02-05 22:03:54', 'user12345', 'Une super serie !', 'The Big Bang Theory'); 
INSERT INTO Critiques VALUES(2, '2014-11-25 15:42:06', 'welshman', 'j kiff tro daeneris !!!!! :) 8)', 'Game of Thrones');
