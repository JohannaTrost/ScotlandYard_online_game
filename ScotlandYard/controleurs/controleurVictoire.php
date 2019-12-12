<?php 
if(!isset($_SESSION)) session_start();
include('static/outilsJeu.php');
$connexion = getConnexionBD(); // connexion à la BD
$message = "";

$partieId = mysqli_fetch_assoc(mysqli_query($connexion, "SELECT max(idPartie) AS max FROM Partie"))['max'];
	
if($_SESSION['DETECTS_GAGNE'] == true) {
	$requete = "UPDATE Participe
				 SET victoire_PARTICIPE = 'detectives'
				 WHERE idPartie = '". $partieId . "' ";			

} else if ($_SESSION['COUNT_TOURS_MISTERX'] == 20) { 
	$requete = "UPDATE Participe
				 SET victoire_PARTICIPE = 'mister X'
				 WHERE idPartie = '". $partieId . "'";			
}
$insertion = mysqli_query($connexion, $requete);
if($insertion == FALSE) {
	$message = "Erreur lors de l'insertion des valeurs dans table participe.";
}
session_destroy(); 
?>