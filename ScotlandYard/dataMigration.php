<?php 
//$connexion = getConnexionBD(); // connexion à la BD
$message = "";

// recupération de données quartiers 
$requeteQ = "SELECT idQ, codeInsee, coords, typeQ, nomQ, cpCommune, nomCommune, departement  
			FROM dataset.Quartiers";
$quartiers = mysqli_query($connexion, $requeteQ);
if($quartiers == FALSE) {
	$message .= "Aucune quartier n'a été trouvée dans la base de données!";
}

// recupération de données routes 
$requeteR = "SELECT idQuartierDepart, idQuartierArrivee, transport, isQuartierDepart 
			 FROM dataset.Routes";
$routes = mysqli_query($connexion, $requeteR);
if($routes == FALSE) {
	$message .= "Aucune route n'a été trouvée dans la base de données!";
}
else 
{
	while ($row = mysqli_fetch_assoc($quartiers)) {
		$row['nomSerie '];
    }
}

?>
