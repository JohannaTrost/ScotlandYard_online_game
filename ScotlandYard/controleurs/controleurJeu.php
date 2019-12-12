<?php 
if(!isset($_SESSION)) session_start();
include('static/outilsJeu.php');
$connexion = getConnexionBD(); // connexion à la BD
$message = "";

$arriveesJoueuse = getDestinationsPossibles($_SESSION['QUARTIERS_DEPART']['ids'][0]);
echo "arrivee possibles pour joueuse: " . $arriveesJoueuse['noms'][0];  

if(isset($_POST['boutonValider'])) {
	$arrivee = input2QuartierIdNom($_POST['arrivee']);
	echo "choix de joueuse: " . $_POST['arrivee']; 
	$_SESSION['QUARTIERS_DEPART']['ids'][0] = $arrivee['id']; 
    $_SESSION['QUARTIERS_DEPART']['noms'][0] = $arrivee['nom'];	
    echo "nouveau depart de joueuse: "	. $_SESSION['QUARTIERS_DEPART']['noms'][0];
	deplacerDetectives();
	echo "nouveau depart de detective 1: " . $_SESSION['QUARTIERS_DEPART']['noms'][1];
	$routeMisterX = deplacerMisterX(); 
	// vérifier si les détectives ont encerclé mister X
	if(is_null($routeMisterX)) { $_SESSION['DETECTS_GAGNE'] = true; }
	$arriveesJoueuse = getDestinationsPossibles($_SESSION['QUARTIERS_DEPART']['ids'][0]);
	echo "arrivee possibles pour joueuse apres bouton cliqué: " . $arriveesJoueuse['noms'][0];
	echo $_SESSION['COUNT_TOURS_MISTERX'] . "eme tour de mister X"; 
	
	if($_SESSION['DETECTS_GAGNE'] == true || $_SESSION['COUNT_TOURS_MISTERX'] == 20) {
		// qn a gagné 
		header("Location: index.php?page=victoire");
	}
}
?>