<?php 

$message = "";

// recupération de données Quartiers 
$requeteQ = "SELECT idQ, codeInsee, coords, typeQ, nomQ, cpCommune, nomCommune, departement  
			FROM dataset.Quartiers";
$resultsQ = mysqli_query($connexion, $requeteQ);
if($resultsQ == FALSE) {
	$message .= "Aucune quartier n'a été trouvée dans la base de données!";
}
else 
{
	$qColNames = array ("idQ", "coords", "typeQ", "nomQ", "cpCommune", "nomCommune", "departement");
	$quartiers = array("idQ" => array(), 
					   "codeInsee" => array(), 
					   "coords" => array(), 
					   "typeQ" => array(), 
					   "nomQ" => array(), 
					   "cpCommune" => array(), 
					   "nomCommune" => array(), 
					   "departement" => array());
	
	while($row = mysqli_fetch_assoc($resultsQ)) 
	{
		for($i=0; $i < sizeof($quartiers); $i++)
		{
			$quartiers[qColNames[i]][] = $row[$qColNames[i]];
		}
    }
}


// recupération de données Routes 
$requeteR = "SELECT idQuartierDepart, idQuartierArrivee, transport, isQuartierDepart 
			 FROM dataset.Routes";
$resultsR = mysqli_query($connexion, $requeteR);
if($resultsR == FALSE) {
	$message .= "Aucune route n'a été trouvée dans la base de données!";
}
else 
{
	$rColNames = array ("idQuartierDepart", "idQuartierArrivee", "transport", "isQuartierDepart");
	$routes = array("idQuartierDepart" => array(), 
					   "idQuartierArrivee" => array(), 
					   "transport" => array(), 
					   "isQuartierDepart" => array());
	
	while($row = mysqli_fetch_assoc($resultsR)) 
	{
		for($i=0; $i < sizeof($quartiers); $i++)
		{
			$routes[rColNames[i]][] = $row[$rColNames[i]];
		}
    }
}

// creation of tables

// First check if the table exists not possible here (no right to delete foreign key constraint)

// table of all table names as TABLE_NAME
$requeteT = "SELECT TABLE_NAME 
			FROM INFORMATION_SCHEMA.TABLES 
			WHERE TABLE_TYPE = 'BASE TABLE' 
			AND TABLE_CATALOG='def'"
			
$resultsT = mysqli_query($connexion, $requeteT);
if($resultsT == FALSE) {
	$message .= "Aucune table name n'a été trouvée dans la base de données!";
}
else 
{
	$tableNames = array ();
	while ($row = mysqli_fetch_assoc($resultsT)) {
		$tableNames[] = $row['TABLE_NAME'];
    }
	
	$foreignKeyConsts = array ("Quartiers" => array("FK_Quartiers_idC"), 
							"Commune" => array("FK_Commune_idD"),
							"Routes" => array("FK_Routes_idQ", "FK_Routes_idQ_ARRIVER"),
							"Partie" => array("FK_Partie_idConfiguration"),
							"ToursMisterX" => array("FK_ToursMisterX_idR"),
							"Participe" => array("FK_Participe_idJ", "FK_Participe_idPartie", "FK_Participe_idV"),
							"Inclus" => array("FK_Inclus_idI", "FK_Inclus_idConfiguration"));
	
	$sql = "ALTER TABLE VALUES(\''.$tableNames[0].'\') DROP FOREIGN KEY VALUES(\''.$foreignKeyConsts[$tableNames[0]][->SCHLEIFE].'\');";
	$sql.= "INSERT INTO test(id) VALUES (1); ";
	$sql.= "SELECT COUNT(*) AS _num FROM test; ";

	if (!$mysqli->multi_query($sql)) {
		echo "Multi query failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	do {
		if ($res = $mysqli->store_result()) {
			var_dump($res->fetch_all(MYSQLI_ASSOC));
			$res->free();
		}
	} while ($mysqli->more_results() && $mysqli->next_result());
}
	
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
// transformation de table Quartiers dans dataset
mysql_query("ALTER TABLE dataset.Quartiers 
			DROP cpCommune,
			DROP nomCommune, 
			DROP Departement");

mysqli_close($conn);


?>
