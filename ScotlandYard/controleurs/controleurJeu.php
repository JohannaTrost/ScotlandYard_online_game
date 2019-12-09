<?php 
$connexion = getConnexionBD(); // connexion à la BD
$message = "";

function getTousQuartiersDeparts()
{
	$departIds = array();
	$departNoms = array();
	$requete = "SELECT idQ, nomQ
				FROM Routes JOIN Quartiers
				ON idQ_DEPART = idQ"; 
	$resultat = mysqli_query($GLOBALS['connexion'], $requete);
	// if (mysqli_multi_query($connexion, $requete)) {
	if($resultat==TRUE)
	{
		while ($row = mysqli_fetch_assoc($resultat)) {
			$departIds[] = $row['idQ'];
			$departNoms[] = $row['nomQ']; 	
		}
	}
	$departIds = array_unique($departIds);
	$departNoms = array_unique($departNoms);
	return array($departIds, $departNoms);
}
/*
function idPasDansArray($id, $arr)
{
	foreach ($arr as &$quartier)
	{
		if($quartier[0] == $id)
		{
			return false; 
		}	
	}
	return true;
}
*/
function getNbDetectsDeLaPartie()
{
	$requete = "SELECT nbDetectives 
				FROM Partie 
				WHERE idPartie = (SELECT max(idPartie) AS max 
								  FROM Partie)";
	$resultat = mysqli_query($GLOBALS['connexion'], $requete);
	if($resultat==TRUE)
	{
		$numDetects = mysqli_fetch_assoc($resultat)['nbDetectives'];
		echo $numDetects;
	}
	else 
	{
		$message = "Erreur lors de recherche de la partie et le numéro des détectives en cours.";
	}
	return $numDetects;
}

function initDeparts($quartiersDepart, $numDetects)
{
	/* get unique depart quartiers for all detectives and for mister X (last one) */
	$randIndices = array_rand($quartiersDepart[0], $numDetects + 1);
	$quartierIdsDetectsDepart = array();
	$quartierDetectsDepart = array();
	if (is_array($randIndices) || is_object($randIndices))
    {
		foreach ($randIndices as &$i)
		{
			$quartierIdsDetectsDepart[] = $quartiersDepart[0][$i];
			$quartierDetectsDepart[] = $quartiersDepart[1][$i];
		}
	}
	return array($quartierIdsDetectsDepart, $quartierDetectsDepart);
}

function getDestinationsPossibles($idDepart)
{
	$destinationIds = array();
	$destinationNoms = array();
	$destinationTrans = array();
	$requete = "SELECT idQ_ARRIVER, nomQ, typeTransport
				FROM Routes JOIN Quartiers
				ON idQ_ARRIVER = idQ
				WHERE idQ_DEPART = '" . $idDepart . "'"; 
	$resultat = mysqli_query($GLOBALS['connexion'], $requete);
	// if (mysqli_multi_query($connexion, $requete)) {
	if($resultat==TRUE)
	{
		while ($row = mysqli_fetch_assoc($resultat)) {
			$destinationIds[] = $row['idQ_ARRIVER'];
			$destinationNoms[] = $row['nomQ'];
			$destinationTrans[] = $row['typeTransport'];
		}
	}
	return array($destinationIds, $destinationNoms, $destinationTrans);
}

function deplacerMisterX($quartierDetectsDepart, $numDetects)
{ 
	$arriveesMisterX = getDestinationsPossibles($quartierDetectsDepart[0][$numDetects]);
	for($i=0; $i < $numDetects-1; $i++)
	{
		$pos = array_search($quartierDetectsDepart[0][$i], $arriveesMisterX[0]);
		if(!is_null($pos))
		{
			foreach ($arriveesMisterX as &$distinPossible)
			{
				unset($distinPossible[$pos]);
			}
		}
	}
	if(empty($arriveesMisterX[0])) {  
		return null; 
	} else {
		$randIndex = array_rand($arriveesMisterX[0], 1);
		return array($quartierDetectsDepart[0][$numDetects], $arriveesMisterX[0][$randIndex], $arriveesMisterX[1][$randIndex], $arriveesMisterX[2][$randIndex]); 
	}
}

$misterXwon = false;
$detectsWon = false; 
$numDetects = getNbDetectsDeLaPartie();
$tousQuartiersDepart = getTousQuartiersDeparts();
$quartierDetectsDepart = initDeparts($tousQuartiersDepart, $numDetects); 

$routeMisterX = deplacerMisterX($quartierDetectsDepart, $numDetects); 
if(is_null($routeMisterX)) { $detectsWon = true; }
$arriveesJoueuse = getDestinationsPossibles($quartierDetectsDepart[0][0])

?>