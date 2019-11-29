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
	
?>
