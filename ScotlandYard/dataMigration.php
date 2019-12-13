<?php 
$connexion = getConnexionBD();
$message = "";

// execution de script sql pour créer les tables et les peupler
$file = fopen("createDB.sql","r");
$sqlFile = fread($file, filesize("createDB.sql"));
$sqlArray = explode(';',$sqlFile);
foreach($sqlArray as $requete) 
{
  if(strlen($requete) > 3 && substr(ltrim($requete),0 ,2 ) != '/*') 
  {
    $resultat = mysqli_query($connexion, $requete);
    if(!$resultat) 
	{
      $sqlErreurCode = mysqli_errno();
      $sqlErreurTexte = mysqli_error();
      $sqlRequete = $requete;
      break;
    }
  }
  $sqlErrorCode = 1;
}
if($sqlErrorCode == 1) 
{
  $message = "Script is executed succesfully!";
} else 
{
  $message = "Code erreur: $sqlErreurCode<br/>";
  $message = "texte erreur: $sqlErreurTexte<br/>";
  $message = "Statement:<br/> $sqlRequete<br/>";
}

// recupération de données Quartiers 
$requeteQ = "SELECT idQ, coords  
			FROM dataset.Quartiers";
$resultsQ = mysqli_query($connexion, $requeteQ);
if($resultsQ == FALSE) 
{
	$message .= "Aucune quartier n'a été trouvée dans la base de données!";
}
else 
{
	while($row = mysqli_fetch_assoc($resultsQ)) 
	{
		preg_match_all('/[-+]?\d*\.?\d+/', $row["coords"], $matches);
		$coords = $matches[0]; 
		$latitudes = array();
		$longitudes = array(); 
		for($i=1; $i < sizeof($coords); $i+=2)
		{
			// peupler la table Geometries
			$requeteC = "INSERT INTO Geometries VALUES('".(float)$coords[$i-1]."', '".(float)$coords[$i]."', '".$row["idQ"]."')";
			$resultsC = mysqli_query($connexion, $requeteC);
			if($resultsC == FALSE) {
				$message .= "Aucune quartier n'a été trouvée dans la base de données!";
			}	
		}
	}
}
	
?>
