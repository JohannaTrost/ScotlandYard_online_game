<?php 
if(!isset($_SESSION)) session_start();
$connexion = getConnexionBD(); // connexion à la BD
$message = "";

//-----------------------------------------------------
// Fonctions pour l'init d'une session/ partie
//-----------------------------------------------------

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
	return array('ids' => $departIds, 'noms' => $departNoms);
}

function initDeparts()
{
	/* get unique depart quartiers for all detectives and for mister X (last one) */
	$tousQuartiersDepart = getTousQuartiersDeparts(); 
	$randIndices = array_rand($tousQuartiersDepart['ids'], $_SESSION['NUM_DETECTS'] + 1);
	$quartierIdsDetectsDepart = array();
	$quartierDetectsDepart = array();
	if (is_array($randIndices) || is_object($randIndices))
    {
		foreach ($randIndices as &$i)
		{
			$quartierIdsDetectsDepart[] = $tousQuartiersDepart['ids'][$i];
			$quartierDetectsDepart[] = $tousQuartiersDepart['noms'][$i];
		}
	}
	return array('ids' => $quartierIdsDetectsDepart, 'noms' => $quartierDetectsDepart, 'transports' => array());
}

//-----------------------------------------------------
// Fonctions pour la stratégie basique
//-----------------------------------------------------

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
	return array('ids' => $destinationIds, 'noms' => $destinationNoms, 'transports' => $destinationTrans);
}

function deplacerMisterX()
{ 
	$arriveesMisterX = getDestinationsPossibles($_SESSION['QUARTIERS_DEPART']['ids'][$_SESSION['NUM_DETECTS']]);
	for($i=0; $i < $_SESSION['NUM_DETECTS']-1; $i++)
	{
		$pos = array_search($_SESSION['QUARTIERS_DEPART']['ids'][$i], $arriveesMisterX['ids']);
		if(!is_null($pos))
		{
			unset($arriveesMisterX['ids'][$pos]);
			unset($arriveesMisterX['noms'][$pos]);
			unset($arriveesMisterX['transports'][$pos]);
		}
	}
	if(empty($arriveesMisterX['ids'])) {  
		return null; 
	} else {
		$randIndex = array_rand($arriveesMisterX['ids'], 1);
		$_SESSION['COUNT_TOURS_MISTERX'] += 1;
		$partieId = mysqli_fetch_assoc(mysqli_query($GLOBALS['connexion'], "SELECT max(idPartie) AS max FROM Partie"))['max'];
		$requete = "INSERT INTO ToursMisterX
					VALUES('" . $partieId . "',
						   '" . $_SESSION['COUNT_TOURS_MISTERX'] . "',
						   '" . $_SESSION['QUARTIERS_DEPART']['ids'][$_SESSION['NUM_DETECTS']] . "',
               			   '" . $arriveesMisterX['ids'][$randIndex] . "',
						   '" . $arriveesMisterX['transports'][$randIndex] . "')"; 
		$resultat = mysqli_query($GLOBALS['connexion'], $requete);
		
		$_SESSION['QUARTIERS_DEPART']['ids'][$_SESSION['NUM_DETECTS']] = $arriveesMisterX['ids'][$randIndex]; 
		$_SESSION['QUARTIERS_DEPART']['noms'][$_SESSION['NUM_DETECTS']] = $arriveesMisterX['noms'][$randIndex];
		echo "arrivee de mister x: " . $_SESSION['QUARTIERS_DEPART']['noms'][$_SESSION['NUM_DETECTS']]; 
		return array($arriveesMisterX['transports'][$randIndex]); 
	}
}


function deplacerDetectives()
{
	echo 'numer of detectives: ' . $_SESSION['NUM_DETECTS']; 
	echo nl2br(" \n ");
	// déplace chaque détective sauf la joueuse 
	for($i=1; $i < $_SESSION['NUM_DETECTS']; $i++)
	{
		echo nl2br('detective ' . $i . ': \n'); 
		$arriveesPossibles = getDestinationsPossibles($_SESSION['QUARTIERS_DEPART']['ids'][$i]); // funktioniert
		//echo "outilsJeu: arrivee possible autre detective: " . $arriveesPossibles['noms'][0]; 
		// si un quartier est le même qu'un des autres detectives déjà deplacés, supprime-le 
		for($j=0; $j < $i; $j++)
		{	
			// s'il n'y a qu'un quartier à choisir évite de le supprimer de la liste même si quelqu'un est déjà dans ce quarier 
			if(sizeof($arriveesPossibles['ids']) > 1)
			{
				$pos = array_search($_SESSION['QUARTIERS_DEPART']['ids'][$j], $arriveesPossibles['ids']);
				if($pos != false)
				{
					unset($arriveesPossibles['ids'][$pos]);
					unset($arriveesPossibles['noms'][$pos]);
					unset($arriveesPossibles['transports'][$pos]);
				}
			}
		}
		echo nl2br ("arrivees possibles: \n "); 
		foreach($arriveesPossibles['noms'] as &$arrivee)
		{
			echo $arrivee . " ";
		}
		echo nl2br (" \n"); 
		// vérifier si un des quartiers est le quartier de mister X 
		$posMisterX = array_search($_SESSION['QUARTIERS_DEPART']['ids'][$_SESSION['NUM_DETECTS']], $arriveesPossibles['ids']);
		if($posMisterX == false)
		{
			$randIndex = array_rand($arriveesPossibles['ids'], 1);
			$_SESSION['QUARTIERS_DEPART']['ids'][$i] = $arriveesPossibles['ids'][$randIndex];
			$_SESSION['QUARTIERS_DEPART']['noms'][$i] = $arriveesPossibles['noms'][$randIndex];
			echo "arrivee choisit: " . $_SESSION['QUARTIERS_DEPART']['noms'][$i]; 
			echo nl2br (" \n");
			// peut-être la prochaine fois :-( 	
		}
		else 
		{ 
			$_SESSION['QUARTIERS_DEPART']['ids'][$i] = $arriveesPossibles['ids'][$posMisterX];
			$_SESSION['QUARTIERS_DEPART']['noms'][$i] = $arriveesPossibles['noms'][$posMisterX];
			echo "trouve mister x dans quartier: " . $_SESSION['QUARTIERS_DEPART']['noms'][$i]; 
			echo nl2br (" \n");
			// wuhuu on a gagné :-)
			$_SESSION['DETECTS_GAGNE'] = true; 
		}
	}
}
//-----------------------------------------------------
// Fonctions pour la stratégie pistage
//-----------------------------------------------------

//-----------------------------------------------------
// Fonctions d'aide
//-----------------------------------------------------

function str($input)
{
	return str_replace(' ', '&nbsp;', $input); 
}

function input2QuartierIdNom($input)
{
	if (is_numeric(substr($input, 0, 3))) 
	{
		return array('id' => (int)substr($input, 0, 3), 'nom' => substr($input, 3)); 	
	}
	else if (is_numeric(substr($input, 0, 2))) 
	{
		return array('id' => (int)substr($input, 0, 2), 'nom' => substr($input, 2)); 	
	}
	else 
	{
		return array('id' => (int)substr($input, 0, 1), 'nom' => substr($input, 1)); 
	}
}
?>