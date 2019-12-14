<?php 
if(!isset($_SESSION)) session_start();
include('static/outilsJeu.php');
$connexion = getConnexionBD(); // connexion à la BD
$message = "";

$arriveesJoueuse = getDestinationsPossibles($_SESSION['QUARTIERS_DEPART']['ids'][0]);

if(isset($_POST['boutonValider'])) {
	$arrivee = input2QuartierIdNom($_POST['arrivee']);
	$_SESSION['QUARTIERS_DEPART']['ids'][0] = $arrivee['id']; 
    $_SESSION['QUARTIERS_DEPART']['noms'][0] = $arrivee['nom'];	
	deplacerDetectives();
	$routeMisterX = deplacerMisterX();
	// vérifier si les détectives ont encerclé mister X
	if(is_null($routeMisterX)) 
	{ 
		$_SESSION['DETECTS_GAGNE'] = true;
	}
	else if ($_SESSION['STRATEGIE'] == 'pistage')
	{
		$quartierJoueuse = array('id' => $_SESSION['QUARTIERS_DEPART']['ids'][0],
						 'nom' => $_SESSION['QUARTIERS_DEPART']['noms'][0]);
		$quartierMisterX = array('id' => $_SESSION['QUARTIERS_DEPART']['ids'][$_SESSION['NUM_DETECTS']],
						 'nom' => $_SESSION['QUARTIERS_DEPART']['noms'][$_SESSION['NUM_DETECTS']]);
		$plusCourtChemin = AStar($quartierJoueuse, $quartierMisterX); 
	}
	
	$arriveesJoueuse = getDestinationsPossibles($_SESSION['QUARTIERS_DEPART']['ids'][0]);
	if($_SESSION['DETECTS_GAGNE'] == true || $_SESSION['COUNT_TOURS_MISTERX'] == 20) {
		// qn a gagné 
		header("Location: index.php?page=victoire");
	}
}
?>