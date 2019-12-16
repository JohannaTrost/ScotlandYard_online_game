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
		return $arriveesMisterX['transports'][$randIndex]; 
	}
}


function deplacerDetectives()
{
	// déplace chaque détective sauf la joueuse 
	for($i=1; $i < $_SESSION['NUM_DETECTS']; $i++)
	{
		$nouveauQuartier = choixDestination($i);
		$_SESSION['QUARTIERS_DEPART']['ids'][$i] = $nouveauQuartier['id'];
		$_SESSION['QUARTIERS_DEPART']['noms'][$i] = $nouveauQuartier['nom'];
	}
}

function choixDestination($indDetect)
{ 
	switch ($_SESSION['STRATEGIE']) 
	{
		case "basique":

			$arriveesPossibles = getDestinationsPossibles($_SESSION['QUARTIERS_DEPART']['ids'][$indDetect]);
			// si un quartier est le même qu'un des autres detectives déjà deplacés, supprime-le 
			for($j=0; $j < $indDetect; $j++)
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
			// vérifier si un des quartiers est le quartier de mister X 
			$posMisterX = array_search($_SESSION['QUARTIERS_DEPART']['ids'][$_SESSION['NUM_DETECTS']], $arriveesPossibles['ids']);
			if($posMisterX == false)
			{
				$randIndex = array_rand($arriveesPossibles['ids'], 1);
				// peut-être la prochaine fois :-(
				return array('id' => $arriveesPossibles['ids'][$randIndex],
							 'nom' => $arriveesPossibles['noms'][$randIndex]);
			}
			else 
			{ 
				// wuhuu on a gagné :-)
				$_SESSION['DETECTS_GAGNE'] = true; 
				return array('id' => $arriveesPossibles['ids'][$posMisterX],
							 'nom' => $arriveesPossibles['noms'][$posMisterX]);
			}
			break;
			
		case "econome":
			$arriveesPossibles = getDestinationsPossibles($_SESSION['QUARTIERS_DEPART']['ids'][$indDetect]);
			// si un quartier est le même qu'un des autres detectives déjà deplacés, supprime-le 
			for($j=0; $j < $indDetect; $j++)
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
			foreach($arriveePossibles as &$arrivee)
			{
				
			}
			// vérifier si un des quartiers est le quartier de mister X 
			$posMisterX = array_search($_SESSION['QUARTIERS_DEPART']['ids'][$_SESSION['NUM_DETECTS']], $arriveesPossibles['ids']);
			if($posMisterX == false)
			{
				$randIndex = array_rand($arriveesPossibles['ids'], 1);
				// peut-être la prochaine fois :-(
				return array('id' => $arriveesPossibles['ids'][$randIndex],
							 'nom' => $arriveesPossibles['noms'][$randIndex],
							 'transport' => $arriveesPossibles['transports'][$randIndex]);
			}
			else 
			{ 
				// wuhuu on a gagné :-)
				$_SESSION['DETECTS_GAGNE'] = true; 
				return array('id' => $arriveesPossibles['ids'][$posMisterX],
							 'nom' => $arriveesPossibles['noms'][$posMisterX],
							 'transport' => $arriveesPossibles['transports'][$randIndex]);
			}
			break;
			
		case "pistage":
			
			$quartierJoueuse = array('id' => $_SESSION['QUARTIERS_DEPART']['ids'][$indDetect],
									 'nom' => $_SESSION['QUARTIERS_DEPART']['noms'][$indDetect]);
			$quartierMisterX = array('id' => $_SESSION['QUARTIERS_DEPART']['ids'][$_SESSION['NUM_DETECTS']],
									 'nom' => $_SESSION['QUARTIERS_DEPART']['noms'][$_SESSION['NUM_DETECTS']]);
			$plusCourtChemin = AStar($quartierJoueuse, $quartierMisterX); 
			
		    if($quartierMisterX['id'] == $plusCourtChemin[1]['id'])
			{
				// wuhuu on a gagné :-)
				$_SESSION['DETECTS_GAGNE'] = true;
			}
			return array('id' => $plusCourtChemin[1]['id'],
						 'nom' => $plusCourtChemin[1]['nom']);
			break;
	}
}
//-----------------------------------------------------
// Fonctions pour la stratégie pistage
//-----------------------------------------------------

function AStar($debut, $misterX)
{
    // L'ensemble des nœuds découverts qui peuvent avoir besoin d'être (ré)étendus
	$fileAttente = array();
    
    // Pour le noeud n, venuDe[n] est le noeud qui le précède immédiatement sur le chemin le moins cher du début à la fin
    $venuDe = array(); //debut

    // Pour le nœud n, gCout[n] est le coût du chemin le moins cher du début jusqu'à n actuellement connu
    $gCout = 0; // debut

    // For node n, fScore[n] := gCout[n] + h(n)
    $hCout = coutEstime($debut['id'], $misterX['id']); // debut
	
	// Initialement, seul le nœud de départ est connu
    $fileAttente[] = array('id' => $debut['id'],
						   'nom' => $debut['nom'],
						   'fCout' => $hCout + $gCout,
						   'gCout' => $gCout,
						   'venuDe' => $venuDe); 
	
    while(!empty($fileAttente))
	{
		usort($fileAttente,"cmp"); 
		// le noeud dans fileAttente ayant la valeur fCout[] la plus basse
		$courant = $fileAttente[0];
		
        if($courant['id'] == $misterX['id'])
		{
            return reconstChemin($courant); 
		}
        array_shift($fileAttente);

		$arrivees = getDestinationsPossibles($courant['id']); 
        for($i=0; $i < sizeof($arrivees['ids']); $i++)
		{
			// d(courant,voisin) = 1 est le poids du bord de courant à voisin
            // gCoutThéorique est la distance entre le point de départ et le voisin à travers le courant.
            $gCoutTheorique = $courant['gCout'] + 1;
			$voisin = array('id' => $arrivees['ids'][$i],
							'nom' => $arrivees['noms'][$i], 
							'fCout' => coutEstime($arrivees['ids'][$i], $misterX['id']) + $gCoutTheorique, 
							'gCout' => $gCoutTheorique, 
							'venuDe' => $courant); 
			$ids = array_column($fileAttente, 'id'); 
			$trouve = array_search($voisin['id'], $ids);
            if( $trouve === false)
			{
                $fileAttente[] = $voisin;
			}
			else 
			{
				if($fileAttente[$trouve]['gCout'] > $voisin['gCout'])
				{
					$fileAttente[$trouve] = $voisin; 
				}
			}
		}
	}
    // file d'attente est vide mais le but n'a jamais été atteint 
    return false; 
}

function reconstChemin($courant)
{
    $cheminComplet = array($courant);
    while(!empty($courant['venuDe']))
	{
        $courant = $courant['venuDe']; 
        array_unshift($cheminComplet, $courant); 
	}
    return $cheminComplet; 
}


// heuristique
function coutEstime($idDepart, $idArrivee)
{
	$requeteDepart = "SELECT latitude, longitude FROM Geometries WHERE idQ = '".$idDepart."'"; 
	$requeteArrivee = "SELECT latitude, longitude FROM Geometries WHERE idQ = '".$idArrivee."'";
	$resultatDepart = mysqli_query($GLOBALS['connexion'], $requeteDepart);
	$resultatArrivee = mysqli_query($GLOBALS['connexion'], $requeteArrivee);
	if($resultatDepart && $resultatArrivee)
	{
		$coordsDepart = getMoyCoords($resultatDepart);
		$coordsArrivee = getMoyCoords($resultatArrivee);
		$distance = sqrt( pow( $coordsDepart['lat'] - $coordsArrivee['lat'], 2 ) + pow( $coordsDepart['lon'] - $coordsArrivee['lon'], 2 ) ); 
		return $distance; 
	}
	else 
	{
		$message = "Erreur lors de récuperation de coordonnées depuis la BD";
	}
}

function getMoyCoords($coords)
{
	$counter = 0; 
	$sumLati = 0; 
	$sumLongi = 0;
	while($row = mysqli_fetch_assoc($coords))
	{
		$counter += 1; 
		$sumLati += $row['latitude'];
		$sumLongi += $row['longitude'];
	}
	return array('lat' => ($sumLati / $counter),
				 'lon' => ($sumLongi / $counter)); 
}

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

function cmp($a, $b)
{
    if ($a["fCout"] == $b["fCout"]) {
        return 0;
    }
    return ($a["fCout"] < $b["fCout"]) ? -1 : 1;
}

?>