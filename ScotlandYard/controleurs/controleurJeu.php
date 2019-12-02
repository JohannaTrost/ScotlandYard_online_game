<?php 
$connexion = getConnexionBD(); // connexion à la BD

if(isset($_POST['boutonValider'])) {
	
	$requete = "SELECT nbDetectives 
				FROM Partie 
				WHERE idPartie = (SELECT max(idPartie) AS max 
								  FROM Partie;)"
				.
				"SELECT idQ_DEPART FROM Routes";
				
	if (mysqli_multi_query($connexion, $requete)) {
		
		if ($result = mysqli_store_result($connexion)) {
			$numDetects = mysqli_fetch_row($result)['nbDetectives'];
			echo $numDetects;
			if(mysqli_next_result($connexion))
			{
				$quartiersDepart = array();
				while ($row = mysqli_fetch_row($result)) {
					$quartiersDepart[] = $row['idQ_DEPART']; 
				}
				echo $quartiersDepart[0];
				$quartiersDepart = array_unique($quartiersDepart);
				/* get unique depart quartiers for all detectives and for mister X (last one) */
				$randIndices = array_rand($quartiersDepart, $numDetects + 1);
				$quartierDetectsDepart = array(); 
				foreach($randIndices as $i)
				{
					$quartierDetectsDepart[] = $quartiersDepart[i];
				}
			}
			else 
			{
				$message = "Erreur: quartiers de départ n'ont pas été trouvés.";
			}
			mysqli_free_result($result);
		}
	}
	else 
	{
		$message = "Erreur lors de recherche de la partie et le numéro des détectives en cours.";
	}
}

?>