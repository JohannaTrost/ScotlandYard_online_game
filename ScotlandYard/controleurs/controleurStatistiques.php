<?php 
$connexion = getConnexionBD(); // connexion à la BD
$message = "";

// recupération nb des Joueuses 
$requete = "SELECT COUNT(DISTINCT idJ) AS nbJ FROM Joueuses";
$nbJ = mysqli_query($connexion, $requete);
if($nbJ == FALSE) {
	$message .= "Aucune joueuse n'a été trouvée dans la base de données!";
}

// recupération nb des Quartiers
$requete = "SELECT COUNT(DISTINCT idQ) AS nbQ FROM Quartiers";
$nbQ = mysqli_query($connexion, $requete);
if($nbQ == FALSE) {
	$message .= "Aucune quartier n'a été trouvée dans la base de données!";
}

// recupération nb des Departements 
$requete = "SELECT COUNT(DISTINCT departement) AS nbD FROM Commune";
$nbD = mysqli_query($connexion, $requete);
if($nbD == FALSE) {
	$message .= "Aucune Departement n'a été trouvée dans la base de données!";
}

// recupération nb des Communes 
$requete = "SELECT COUNT(DISTINCT cpCommune) AS nbC FROM Commune";
$nbC = mysqli_query($connexion, $requete);
if($nbC == FALSE) {
	$message .= "Aucune Commune n'a été trouvée dans la base de données!";
}

// data tables pour comparer les Joueuses 
// idJ et nomJ
// TODO nombre des perdes, Victoires et Parties totales par joueuse et ranking 
$requete = "SELECT idJ, nomJ FROM Joueuses";
$Joueuses = mysqli_query($connexion, $requete);
if($Joueuses == FALSE) {
	$message .= "Aucune joueuse n'a été trouvée dans la base de données!";
}
?>
